import os
from deepface import DeepFace
from retinaface import RetinaFace
from pretreatment import *
from my_sql.models import Employee_db, Record_db, Account_db
# from flask_bcrypt import Bcrypt
from my_sql.base import *
from my_sql.error_set import *
import time


@app.route('/account', methods=['POST'])
def account():
    """'帳號註冊"""
    account = request.form['account']  # 註冊帳號
    password = request.form['password']  # 註冊密碼
    if account == '' or password == '':
        raise InvalidUsage(message='註冊失敗,帳號、密碼、名字不能為空', status_code=400)
    else:
        user = Account_db(
            account=account,
            password=password,
        )
        db.session.add(user)
        db.session.commit()
        return Return().dump({'message': '註冊成功', 'data': {'account': account, 'password': password},
                              'status_code': 200}), 200


@app.route('/login', methods=['POST'])
def login():
    """登入"""
    current_time = time.strftime("%Y-%m-%d %I:%M:%S", time.localtime())
    account = request.form['account']  # 帳號
    password = request.form['password']  # 密碼
    data = Account_db.query.filter(Account_db.account == account, Account_db.password == password,
                                   Account_db.is_delete == 0).one_or_none()
    if data is None:
        raise InvalidUsage(message='查無此帳號,帳號、密碼錯誤', status_code=400)
    data.gmt_update = current_time
    db.session.commit()
    return Return().dump({'message': '登入成功', 'data': {'account': account, 'login_time': current_time},
                          'status_code': 200}), 200


@app.route('/select', methods=['GET'])
def select_all():
    """資料庫搜尋"""
    table = request.values.get('table')  # 資料表名稱
    page = request.values.get('page')  # 頁數
    page_data = []
    if table == 'account':
        data = Account_db.query.filter_by(is_delete=0).order_by(Account_db.id.asc()).paginate(int(page), 20, True)
        for item in data.items:
            page_data.append({'id': item.id, 'account_id': item.account, 'password': item.password, 'name': item.name})
        return Return().dump({'message': '搜尋成功', 'data': {'mysql': page_data}, 'status_code': 200}), 200
    elif table == 'employee':
        data = Employee_db.query.filter_by(is_delete=0).order_by(Employee_db.id.asc()).paginate(int(page), 30, True)
        for item in data.items:
            img = cv2.imread(item.root)
            b64 = image_to_base64(img)
            page_data.append({'id': item.id, 'account': item.account_id, 'embedding': b64, 'name': item.name,
                              'u_id': item.u_id, 'gmt_create': item.gmt_create, 'gmt_update': item.gmt_update})
        return Return().dump({'message': '搜尋成功', 'data': {'mysql': page_data}, 'status_code': 200}), 200
    elif table == 'record':
        data = Record_db.query.filter_by(is_delete=0).order_by(Record_db.id.asc()).paginate(int(page), 30, True)
        for item in data.items:
            img = cv2.imread(item.root)
            b64 = image_to_base64(img)
            page_data.append({'id': item.id, 'account': item.employee_id, 'embedding': b64, 'name': item.name,
                              'gmt_create': item.gmt_create, 'gmt_update': item.gmt_update})
        return Return().dump({'message': '搜尋成功', 'data': {'mysql': page_data}, 'status_code': 200}), 200
    else:
        raise InvalidUsage(message='搜尋失敗, 找不到表', status_code=400)


@app.route('/delete', methods=['POST'])
def delete():
    """刪除"""
    table = request.form['table']  # 資料表名稱
    ID = request.form['id']  # 欲刪除ID
    if table == 'account':
        data = Account_db.query.filter_by(id=ID).first()
        if data is None:
            raise InvalidUsage(message='刪除失敗,找不到ID', status_code=400)
        data.is_delete = 1
        db.session.commit()
        return Return().dump({'message': '刪除成功', 'status_code': 200}), 200
    elif table == 'employee':
        data = Employee_db.query.filter_by(id=ID).first()
        if data is None:
            raise InvalidUsage(message='刪除失敗,找不到ID', status_code=400)
        data.is_delete = 1
        db.session.commit()
        return Return().dump({'message': '刪除成功', 'status_code': 200}), 200
    elif table == 'record':
        data = Record_db.query.filter_by(id=ID).first()
        if data is None:
            raise InvalidUsage(message='刪除失敗,找不到ID', status_code=400)
        data.is_delete = 1
        db.session.commit()
        return Return().dump({'message': '刪除成功', 'status_code': 200}), 200
    else:
        raise InvalidUsage(message='刪除失敗,找不到表', status_code=400)


@app.route('/update', methods=['POST'])
def update():
    """修改"""
    table = request.form['table']  # 資料表名稱
    ID = request.form['id']  # 欲修改ID
    update_dic = {}
    for i in request.form:
        # 更新時請求update-'欲修改欄位'
        if len(i.split('-')) > 1:
            update_dic.update({i.split('-')[1]: request.form[i]})

    if table == 'account':
        Account_db.query.filter(Account_db.id == ID, Account_db.is_delete == 0).update(update_dic)
        db.session.commit()
        return Return().dump({'message': '修改成功', 'status_code': 200}), 200
    elif table == 'employee':
        Employee_db.query.filter(Employee_db.id == ID, Employee_db.is_delete == 0).update(update_dic)
        db.session.commit()
        return Return().dump({'message': '修改成功', 'status_code': 200}), 200
    elif table == 'record':
        Record_db.query.filter(Record_db.id == ID, Record_db.is_delete == 0).update(update_dic)
        db.session.commit()
        return Return().dump({'message': '修改成功', 'status_code': 200}), 200
    else:
        raise InvalidUsage(message='修改失敗,找不到表', status_code=400)


@app.route('/reg', methods=['POST'])
def registration():
    """人臉辨識註冊"""
    start = time.time()
    name = request.form['name']  # 姓名
    account_id = request.form['account_id']  # 帳號ID
    myclass = request.form['myclass']  # 系所
    u_id = request.form['u_id']  # 學號
    image = request.files['image']  # 人臉
    gender = request.form['gender']  # 性別
    if name == '' or u_id == '' or image == '':
        raise InvalidUsage(message='註冊失敗,名字、u_id、人臉不能為空', status_code=400)
    data = Employee_db.query.filter(Employee_db.u_id == u_id, Employee_db.is_delete == 0).one_or_none()
    if not data:
        image = file_stream_to_cv2(image)
        origin = os.path.join('data/origin_img', str(start) + '.jpg')
        cv2.imwrite(origin, image)
        # faces = DeepFace.detectFace(image, detector_backend='retinaface')
        faces = RetinaFace.extract_faces(img_path=image, align=False)[0]
        img = cv2.cvtColor(np.asarray(faces), cv2.COLOR_RGB2BGR)
        b64 = image_to_base64(img)
        head_cut = os.path.join('data/head_cut', str(start) + '.jpg')
        cv2.imwrite(head_cut, img)
        user = Employee_db(
            account_id=account_id,
            root=head_cut,
            myclass=myclass,
            name=name,
            u_id=u_id,
            gender=gender
        )
        db.session.add(user)
        db.session.commit()
        return Return().dump({'message': '註冊成功', 'data': {'account_id': account_id, 'embedding': b64, 'name': name,
                                                          'u_id': u_id, 'gender': gender}, 'status_code': 200}), 200
    else:
        raise InvalidUsage(message='註冊失敗,u_id已存在', status_code=400)


def get_embedding(path_root):
    data = Employee_db.query.filter(Employee_db.root == path_root, Employee_db.is_delete == 0).one_or_none()
    if data is None:
        os.remove('data/head_cut/representations_arcface.pkl')
        raise InvalidUsage(message='查無此人', status_code=400)
    return data


def insert(employee_id, root, myclass, name, u_id, gender):
    user = Record_db(
        employee_id=int(employee_id),
        root=root,
        myclass=myclass,
        name=name,
        u_id=u_id,
        gender=gender
    )
    db.session.add(user)
    db.session.commit()


@app.route('/face', methods=['POST'])
def face():
    """人臉辨識"""
    start = time.time()
    # current_time = time.strftime("%Y-%m-%d ˊ:%S", time.localtime())
    image = request.files['image']  # 人臉
    image = file_stream_to_cv2(image)

    models = ["VGG-Face", "Facenet", "Facenet512", "OpenFace", "DeepFace", "DeepID", "ArcFace", "Dlib"]
    search_root = 'data/head_cut'
    result = DeepFace.find(image, search_root, model_name=models[6], enforce_detection=False)
    path = result['identity'][0]
    b64 = image_to_base64(cv2.imread(result['identity'][0]))
    os.remove('data/head_cut/representations_arcface.pkl')

    usrs = get_embedding(path)
    record_root = 'data/record_image/%s.jpg' % start
    image = cv2.resize(image, (256, 256), interpolation=cv2.INTER_AREA)
    cv2.imwrite(record_root, image)
    insert(usrs.id, record_root, usrs.myclass, usrs.name, usrs.u_id, usrs.gender)
    return {'image': b64, 'id': usrs.id, 'class': usrs.myclass, 'name': usrs.name, 'u_id': usrs.u_id,
            'gender': usrs.gender, 'status_code': 200}, 200


if __name__ == '__main__':
    app.debug = True
    app.run(host='0.0.0.0', port=5001)


