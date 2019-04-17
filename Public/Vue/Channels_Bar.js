
export default Vue.component('channel-bar', {
    data: function () {
        return {
            css: {
                bar: {
                    width: '5em',
                    background: 'black',
                },
            }
        }
    },
    template: `
    <div :style="css.bar">
        <ul>

        </ul>
    </div>
    `,
});