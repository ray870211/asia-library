import 'bootstrap.css';
import '@grapecity/wijmo.styles/wijmo.css';
import './styles.css';
import {
  Component, Inject, enableProdMode, NgModule, ViewChild, AfterViewInit
} from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';
import { BrowserModule } from '@angular/platform-browser';
import { WjNavModule, WjTreeView } from '@grapecity/wijmo.angular2.nav';
import { DataService, TreeItem } from './app.data';

//
@Component({
  selector: 'app-component',
  templateUrl: 'src/app.component.html'
})
export class AppComponent implements AfterViewInit {
  @ViewChild('theTree', { static: true }) theTree: WjTreeView;
  data: TreeItem[];
  //
  constructor(@Inject(DataService) private dataService: DataService) {
    this.data = dataService.getData();
  }
  //
  ngAfterViewInit() {
    this.theTree.selectedItem = this.theTree.itemsSource[0];
  }
  //
  onFirstClick() {
    var theTree = this.theTree;
    var newItem = { header: (document.getElementById('theInput') as HTMLInputElement).value },
      node = theTree.selectedNode;
    if (node) {
      theTree.selectedNode = node.addChildNode(0, newItem);
    } else {
      theTree.selectedNode = theTree.addChildNode(0, newItem);
    }
  }
  //
  onLastClick() {
    var theTree = this.theTree;
    var newItem = { header: (document.getElementById('theInput') as HTMLInputElement).value },
      node = theTree.selectedNode;
    if (node) {
      var index = node.nodes ? node.nodes.length : 0;
      theTree.selectedNode = node.addChildNode(index, newItem);
    } else {
      var index = theTree.nodes ? theTree.nodes.length : 0;
      theTree.selectedNode = theTree.addChildNode(index, newItem);
    }
  }
  //
  onNoSelClick() {
    this.theTree.selectedNode = null;
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
//
enableProdMode();
// Bootstrap application with hash style navigation and global services.
platformBrowserDynamic().bootstrapModule(AppModule);

