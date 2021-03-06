import 'bootstrap.css';
import '@grapecity/wijmo.styles/wijmo.css';
import './styles.css';
import * as wjCore from '@grapecity/wijmo';

import {
  Component, Inject, enableProdMode, NgModule, ViewChild, AfterViewInit
} from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { BrowserModule } from '@angular/platform-browser';
import { WjNavModule, WjTreeView } from '@grapecity/wijmo.angular2.nav';
import { DataService, TreeItem } from './app.data';

@Component({
  selector: 'app-component',
  templateUrl: 'src/app.component.html'
})
export class AppComponent implements AfterViewInit {
  @ViewChild('theTree', { static: true }) theTree: WjTreeView;
  data: TreeItem[];

  constructor(@Inject(DataService) private dataService: DataService) {
    this.data = dataService.getData();
  }

  ngAfterViewInit() {
    this.theTree.selectedItem = this.theTree.itemsSource[0];
  }

  onSelectedItemChanged() {
    let btn = document.getElementById('btnRemove');
    wjCore.setAttribute(btn, 'disabled', this.theTree.selectedItem ? null : 'disabled');
  }
  //
  onRemoveClick() {
    let theTree = this.theTree;
    if (theTree.selectedItem) {

      // find the array that contains the item to be removed
      let parent = theTree.selectedNode.parentNode;
      let arr = parent
        ? parent.dataItem[theTree.childItemsPath as string]
        : theTree.itemsSource;

      // remove the item from the parent collection
      let index = arr.indexOf(theTree.selectedItem);
      arr.splice(index, 1);

      // refresh the tree
      theTree.loadTree();
    }
  }
}
//
@NgModule({
  imports: [WjNavModule, BrowserModule],
  declarations: [AppComponent],
  providers: [DataService],
  bootstrap: [AppComponent]
})
export class AppModule {
}

enableProdMode();

// Bootstrap application with hash style navigation and global services.
platformBrowserDynamic().bootstrapModule(AppModule);

