export default Vue.component('groupchat-bar', {
    data: function () {
        return {
            css: {
                streamButton: {
                    width: '100%',
                },
                bar: {
                    width: '8em',
                    background: '#484a4c',
                },
            },
        }
    },
    template: `
    <div :style="css.bar">
    <button :style="css.streamButton">Stream</button>
        <ul>

        </ul>
    </div>
    `,
});