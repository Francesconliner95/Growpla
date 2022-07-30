import Vue from 'vue';
import axios from 'axios';
//import Chart from 'chart.js';
import moment from 'moment';
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': window.csrf_token
};

var create = new Vue({
    el: '#support-index',
    data: {
        supportTypes,
        usertypes,
        users_date,
        pages_date,
        users_comp_date,
        users_incomp_date,
        supports: '',
        //user e pages
        user_chart: '',
        labels: '',
        year_selected: '',
        month_selected: '',
        years: [],
        user_data: [],
        page_data: [],
        //user complete e incomplete
        user_comp_chart: '',
        labels_comp: '',
        year_comp_selected: '',
        month_comp_selected: '',
        user_comp_data: [],
        user_incomp_data: [],
    },

    methods: {
        getAllSupports(){
            axios.get('/admin/getAllSupports',{
            }).then((response) => {
                this.supports = response.data.results.supports;
            });
        },

        getYears(){
            this.users_date.forEach((date, i) => {
                let year = moment(date).format('YYYY');
                if(!this.years.includes(year)){
                    this.years.push(year);
                }
            });
            this.years.sort();

            this.select_year();
            this.select_comp_year();
        },

        //users e pages
        select_year(){
            this.labels = [];
            this.month_selected = '';
            this.user_data = [];
            this.page_data = [];
            if(this.year_selected){
                //LABEL
                this.labels = [
                    "Gennaio",
                    "Febbraio",
                    "Marzo",
                    "Aprile",
                    "Maggio",
                    "Giungo",
                    "Luglio",
                    "Agosto",
                    "Settembre",
                    "Ottobre",
                    "Novembre",
                    "Dicembre",
                ];
                //DATA
                this.labels.forEach((month, i) => {
                    //user
                    let user_count = 0;
                    this.users_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_selected
                         && moment(user_date).format('MM')==i+1){
                            user_count++;
                        }
                    });
                    this.user_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.pages_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_selected
                         && moment(page_date).format('MM')==i+1){
                            page_count++;
                        }
                    });
                    this.page_data.push(page_count);
                });
            }else{
                //LABEL
                this.labels = this.years;
                //DATA
                this.labels.forEach((year, i) => {
                    //user
                    let user_count = 0;
                    this.users_date.forEach((user_date, i)=>{
                        if(moment(user_date).format('YYYY')==year){
                            user_count++;
                        }
                    });
                    this.user_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.pages_date.forEach((page_date, i)=>{
                        if(moment(page_date).format('YYYY')==year){
                            page_count++;
                        }
                    });
                    this.page_data.push(page_count);
                });

            }
            if(this.user_chart){
                this.user_chart.destroy();
            }
            this.createUserChart();
        },

        select_month(){
            this.labels = [];
            this.user_data = [];
            this.page_data = [];
            if(this.month_selected){
                //LABEL
                let days_in_month = moment(this.year_selected+"-"+this.month_selected, "YYYY-MM").daysInMonth(); // 29
                for (var i = 0; i < days_in_month; i++) {
                    this.labels.push(i+1);
                }
                //DATA
                this.labels.forEach((day, i) => {
                    //user
                    let user_count = 0;
                    this.users_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_selected
                         && moment(user_date).format('MM')==this.month_selected
                         && moment(user_date).format('DD')==day){
                            user_count++;
                        }
                    });
                    this.user_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.pages_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_selected
                         && moment(page_date).format('MM')==this.month_selected
                         && moment(page_date).format('DD')==day){
                            page_count++;
                        }
                    });
                    this.page_data.push(page_count);
                });
            }else{
                //LABEL
                this.labels = [
                    "Gennaio",
                    "Febbraio",
                    "Marzo",
                    "Aprile",
                    "Maggio",
                    "Giungo",
                    "Luglio",
                    "Agosto",
                    "Settembre",
                    "Ottobre",
                    "Novembre",
                    "Dicembre",
                ];
                //DATA
                this.labels.forEach((month, i) => {
                    //user
                    let user_count = 0;
                    this.users_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_selected
                         && moment(user_date).format('MM')==i+1){
                            user_count++;
                        }
                    });
                    this.user_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.pages_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_selected
                         && moment(page_date).format('MM')==i+1){
                            page_count++;
                        }
                    });
                    this.page_data.push(page_count);
                });
            }

            if(this.user_chart){
                this.user_chart.destroy();
            }
            this.createUserChart();
        },

        createUserChart(){
            const users_date_ctx = document.getElementById('usersDate').getContext('2d');
            this.user_chart = new Chart(users_date_ctx, {
                type: 'line',
                data: {
                    labels: this.labels,
                    datasets: [
                        {
                            label: 'utenti',
                            data: this.user_data,
                            backgroundColor: 'rgba(155, 255, 55, 0.2)',
                            borderColor:'rgba(155, 255, 55, 1)',
                            fill: true,
                            borderWidth: 1
                        },
                        {
                            label: 'pagine',
                            data: this.page_data,
                            backgroundColor:'rgba(155, 99, 255, 0.2)',
                            borderColor:'rgba(155, 99, 255, 1)',
                            fill: true,
                            borderWidth: 1
                        }
                    ],
                },
            });
        },

        //users comp e incomp
        select_comp_year(){
            this.labels_comp = [];
            this.month_comp_selected = '';
            this.user_comp_data = [];
            this.user_incomp_data = [];
            if(this.year_comp_selected){
                //LABEL
                this.labels_comp = [
                    "Gennaio",
                    "Febbraio",
                    "Marzo",
                    "Aprile",
                    "Maggio",
                    "Giungo",
                    "Luglio",
                    "Agosto",
                    "Settembre",
                    "Ottobre",
                    "Novembre",
                    "Dicembre",
                ];
                //DATA
                this.labels_comp.forEach((month, i) => {
                    //user
                    let user_count = 0;
                    this.users_comp_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_comp_selected
                         && moment(user_date).format('MM')==i+1){
                            user_count++;
                        }
                    });
                    this.user_comp_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.users_incomp_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_comp_selected
                         && moment(page_date).format('MM')==i+1){
                            page_count++;
                        }
                    });
                    this.user_incomp_data.push(page_count);
                });
            }else{
                //LABEL
                this.labels_comp = this.years;
                //DATA
                this.labels_comp.forEach((year, i) => {
                    //user
                    let user_count = 0;
                    this.users_comp_date.forEach((user_date, i)=>{
                        if(moment(user_date).format('YYYY')==year){
                            user_count++;
                        }
                    });
                    this.user_comp_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.users_incomp_date.forEach((page_date, i)=>{
                        if(moment(page_date).format('YYYY')==year){
                            page_count++;
                        }
                    });
                    this.user_incomp_data.push(page_count);
                });

            }
            if(this.user_comp_chart){
                this.user_comp_chart.destroy();
            }
            this.createUserComplChart();
        },

        select_comp_month(){
            this.labels_comp = [];
            this.user_comp_data = [];
            this.user_incomp_data = [];
            if(this.month_comp_selected){
                //LABEL
                let days_in_month = moment(this.year_comp_selected+"-"+this.month_comp_selected, "YYYY-MM").daysInMonth(); // 29
                for (var i = 0; i < days_in_month; i++) {
                    this.labels_comp.push(i+1);
                }
                //DATA
                this.labels_comp.forEach((day, i) => {
                    //user
                    let user_count = 0;
                    this.users_comp_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_comp_selected
                         && moment(user_date).format('MM')==this.month_comp_selected
                         && moment(user_date).format('DD')==day){
                            user_count++;
                        }
                    });
                    this.user_comp_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.users_incomp_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_comp_selected
                         && moment(page_date).format('MM')==this.month_comp_selected
                         && moment(page_date).format('DD')==day){
                            page_count++;
                        }
                    });
                    this.user_incomp_data.push(page_count);
                });
            }else{
                //LABEL
                this.labels_comp = [
                    "Gennaio",
                    "Febbraio",
                    "Marzo",
                    "Aprile",
                    "Maggio",
                    "Giungo",
                    "Luglio",
                    "Agosto",
                    "Settembre",
                    "Ottobre",
                    "Novembre",
                    "Dicembre",
                ];
                //DATA
                this.labels_comp.forEach((month, i) => {
                    //user
                    let user_count = 0;
                    this.users_comp_date.forEach((user_date, j)=>{
                        if(moment(user_date).format('YYYY')==this.year_comp_selected
                         && moment(user_date).format('MM')==i+1){
                            user_count++;
                        }
                    });
                    this.user_comp_data.push(user_count);
                    //page
                    let page_count = 0;
                    this.users_incomp_date.forEach((page_date, j)=>{
                        if(moment(page_date).format('YYYY')==this.year_comp_selected
                         && moment(page_date).format('MM')==i+1){
                            page_count++;
                        }
                    });
                    this.user_incomp_data.push(page_count);
                });
            }

            if(this.user_comp_chart){
                this.user_comp_chart.destroy();
            }
            this.createUserComplChart();
        },

        createUserComplChart(){
            const users_date_ctx = document.getElementById('usersComplete').getContext('2d');
            this.user_comp_chart = new Chart(users_date_ctx, {
                type: 'line',
                data: {
                    labels: this.labels_comp,
                    datasets: [
                        {
                            label: 'completa',
                            data: this.user_comp_data,
                            backgroundColor: 'rgba(155, 255, 55, 0.2)',
                            borderColor:'rgba(155, 255, 55, 1)',
                            fill: true,
                            borderWidth: 1
                        },
                        {
                            label: 'incompleta',
                            data: this.user_incomp_data,
                            backgroundColor:'rgba(255, 99, 55, 0.2)',
                            borderColor:'rgba(255, 99, 55, 1)',
                            fill: true,
                            borderWidth: 1
                        }
                    ],
                },
            });
        }


    },
    mounted() {
        this.getAllSupports();
        this.getYears();

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: this.usertypes.name,
                datasets: [{
                    data: this.usertypes.count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    }

});
