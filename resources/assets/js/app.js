
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    methods: {
        show: function() {
            if(confirm('Are you sure?')) {
                let type = window.location.pathname.split('/')[1]
                let id = window.location.pathname.split('/')[2]
                axios.delete(`/${type}/${id}`).then(res => {
                    if(res.status === 200) {
                        alert(`${_.capitalize(type)} deleted successfully`)
                        window.location.href = `/${type}`
                    } else {
                        alert('Error while deleting!')
                    }
                })
            }
        },
        print: function() {
            window.print();
        }
    }
});
