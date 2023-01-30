import Vue from 'vue';


Vue.filter('price', value => {
    if (value % 1 != 0) {
        return value.toFixed(2);
    }
    return value;
});

Vue.filter('text', value => {
    if (value){
        return value.trim();
    }
});

 Vue.filter('datetime', val => {
    return moment(val).format('DD/MM/YYYY H:mm');
 });

Vue.filter('slug', str => {

    if (typeof str != 'string') {
        return str;
    }

    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaeeeeiiiioooouuuunc------";
    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-'); // collapse dashes

    return str;
});

Vue.filter('ucFirst',(string)=>{
    if(!string)return;
     return string.charAt(0).toUpperCase() + string.slice(1);
})