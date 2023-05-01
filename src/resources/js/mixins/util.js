import {Modal} from "bootstrap";
export default {
    methods: {
        hideModal: function () {
            document.querySelectorAll('.modal').forEach(modal => {
                (new Modal(document.getElementById(modal.id)))._hideModal()
            })
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove())
        }
    }
}
