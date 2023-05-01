export default {
    methods: {
        nl2br: function (str) {
            return (str || '').replaceAll('\n', '<br>')
        },
        substrWithDots: function (str, length = 45) {
            return str.length > length ? `${str.substring(0, length)}...` : str
        },
        formatDate: function (str) {
            return (new Date(str)).toLocaleString()
        }
    }
}
