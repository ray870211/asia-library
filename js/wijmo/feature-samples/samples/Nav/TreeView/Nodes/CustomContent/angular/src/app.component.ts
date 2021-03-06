import 'bootstrap.css';
import '@grapecity/wijmo.styles/wijmo.css';
import './styles.css';
import * as wjNav from '@grapecity/wijmo.nav';
import {
  Component, Inject, enableProdMode, NgModule
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
export class AppComponent {
  data: TreeItem[];
  //
  constructor(@Inject(DataService) private dataService: DataService) {
    this.data = dataService.getData();
  }
  onFormatItem(e: wjNav.FormatNodeEventArgs) {
    if (e.dataItem.newItem) {
      let imgUrl = 'resources/new.png';
      e.element.innerHTML +=
        '<img class="new-icon" src="' + imgUrl + '">';
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
//
enableProdMode();
// Bootstrap application with hash style navigation and global services.
platformBrowserDynamic().bootstrapModule(AppModule);

