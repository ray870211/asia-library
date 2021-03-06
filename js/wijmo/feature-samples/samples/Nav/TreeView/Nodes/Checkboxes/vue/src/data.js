export function getData() {
    return [
        {
            header: 'Electronics',
            items: [
                { header: 'Trimmers/Shavers' },
                { header: 'Tablets' },
                {
                    header: 'Phones',
                    items: [
                        { header: 'Apple' },
                        { header: 'Motorola', newItem: true },
                        { header: 'Nokia' },
                        { header: 'Samsung' }
                    ]
                },
                { header: 'Speakers', newItem: true },
                { header: 'Monitors' }
            ]
        },
        {
            header: 'Toys',
            items: [
                { header: 'Shopkins' },
                { header: 'Train Sets' },
                { header: 'Science Kit', newItem: true },
                { header: 'Play-Doh' },
                { header: 'Crayola' }
            ]
        },
        {
            header: 'Home',
            items: [
                { header: 'Coffee Maker' },
                { header: 'Breadmaker', newItem: true },
                { header: 'Solar Panel', newItem: true },
                { header: 'Work Table' },
                { header: 'Propane Grill' }
            ]
        }
    ];
}