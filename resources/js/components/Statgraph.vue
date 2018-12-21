<template>
    <div :id="this.name"></div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true,
            },
            title: {
                type: String,
                required: false,
                default: ''
            },
            valueLabel: {
                type: String,
                required: false,
                default: 'Occurrences'
            },
            endpoint: {
                type: String,
                required: true,
            },
            method: {
                type: String,
                required: false,
                default: "get"
            },
            poll: {
                required: false,
                default: null
            }
        },
        data() {
            return {
                data: [],
                status: 'ready',
                dates: []
            }
        },
        mounted() {
            this.init();
            if(this.pollingInterval != null) {
                setInterval(() => {
                    this.init();
                }, this.pollingInterval);
            }
        },
        methods: {
            init() {
                this.status = 'loading';
                this.fetchData().then(() => {
                    this.initChart();
                    Vue.nextTick(() => {
                        this.status = 'ready';
                    })
                }).catch(() => {
                    this.status = 'error';
                });
            },
            initChart() 
            
            {
                window.Highcharts.chart(this.name, {
                    chart: {
                    type: 'column'
                },

                title: {
                    text: this.title
                },

                xAxis: {
                    categories: this.dates,
                    title: {
                        text: 'Date'
                    }
                },

                yAxis: {
                    categories: [],
                    title: {
                        text: 'Total'
                    }
                },

                tooltip: {
                    formatter: function () {
                        return '<b>' + this.x + '</b><br/>' +
                            this.series.name + ': ' + this.y + '<br/>' +
                            'Total: ' + this.point.stackTotal;
                    }
                },

                plotOptions: {
                    column: {
                        stacking: 'column'
                    }
                },

                series: this.getSeries()
                });
            },
            fetchData() {
                return new Promise((resolve, reject) => {
                    axios[this.requestMethod](this.endpoint)
                    .then(response => {
                        this.resolveSuccessfulResponse(response);
                        resolve(); 
                    })
                    .catch(error => {
                        this.resolveFailedResponse(error);
                        reject();
                    });
                })
            },
            resolveSuccessfulResponse(response) {
                this.data = response.data.data;
                
            },
            resolveFailedResponse(error) {
                this.data = [];
            },
            getSeries(){
                var date= [];
                var series= [];
                var elements =[];
                var dataName= [];
                _.forEach(this.data, function(element,item) {
                    dataName = item;
                    elements = element;
                    var keys = Object.keys(element[0]);
                    for(var key in keys) {
                        var propertyName = keys[key];
                        if(propertyName == 'timestamp') {
                            _.map(elements, 'timestamp').forEach(function(element){
                                var dateFromAPI = new Date(element).toLocaleString();
                                date.push(dateFromAPI);
                            });
                        } else {
                            series.push({
                                name: dataName.charAt(0).toUpperCase() + dataName.slice(1),
                                data: _.map(elements, propertyName),
                            });
                        }
                    }
                });
                this.dates.push(date);
                return series; 
            },
        },
        computed: {
            requestMethod() {
                return this.method.toLowerCase();
            },
            pollingInterval() {
                return this.poll != null && this.poll != 'null' 
                    ? parseInt(this.poll) * 1000 
                    : null;
            }
        },
        watch: {
           //
        }
    }
</script>