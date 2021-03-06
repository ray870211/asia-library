import { Injectable } from '@angular/core';

@Injectable()
export class DataService {
    getData() {
        var countries = 'US,Germany,UK,Japan,Italy,Greece'.split(','), data = [];
        for (var i = 0; i < countries.length; i++) {
            data.push({
                country: countries[i],
                sales: Math.random() * 10000,
                expenses: Math.random() * 5000,
                downloads: Math.round(Math.random() * 20000),
            });
        }
        return data;
    }
}