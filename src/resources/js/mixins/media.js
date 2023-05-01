export default {
    methods: {
        nl2br: function (str) {
            return (str || '').replaceAll('\n', '<br>')
        },
        formatSize: function (size) {
            size = Math.round((size * 100) / 1024) / 100
            return size >= 1024 ? `${Math.round((size * 100) / 1024) / 100} mb` : `${size} kb`
        },
        resetActiveElement: function(blocks) {
            for (let block of blocks) {
                if (block.id === this.activeElement.id) {
                    this.setActiveElement(block)
                    break
                }
                this.resetActiveElement(block.blocks || [])
            }
        }
    }
}
