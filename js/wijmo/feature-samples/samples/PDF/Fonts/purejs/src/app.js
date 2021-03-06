import 'bootstrap.css';
import './styles.css';
import * as pdf from '@grapecity/wijmo.pdf';
//
document.readyState === 'complete' ? init() : window.onload = init;
//
function init() {
    document.querySelector('#btnExport').addEventListener('click', () => {
        let doc = new pdf.PdfDocument({
            ended: (sender, args) => pdf.saveBlob(args.blob, 'FlexGrid.pdf')
        });
        //
        doc.drawText('This text uses the default document font, Times 10.');
        //
        doc.drawText('This text uses Times Bold Oblique 20.', null, null, { font: new pdf.PdfFont('times', 20, 'oblique', 'bold') });
        //
        doc.setFont(new pdf.PdfFont('helvetica'));
        doc.drawText('This text uses Helvetica 10.');
        doc.drawText('This text also uses Helvetica 10.');
        //
        doc.end();
    });
}
