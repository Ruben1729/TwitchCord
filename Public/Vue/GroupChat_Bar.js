export default Vue.component('groupchat-bar', {
    props: {
        groups: Array,
    },
    data: function () {
        return {
            css: {
                streamButton: {
                    width: '100%',
                    margin: '5% 0',
                },
                bar: {
                    width: '8em',
                    background: '#484a4c',
                },
                ul: {
                    margin: '0',
                    padding: '0',
                    display: 'flex',
                    flexDirection: 'column',
                    alignItems: 'center',
                }
            },
        }
    },
    methods: {},
    template: `
    <div :style="css.bar">
        <button 
        :style="css.streamButton"
        @click="$emit('stream-state')">Stream</button>
        <ul :style="css.ul">
            <li 
            class="group-item"
            v-for="group in groups" :key="group.group_chat_id"
            @click="$emit('group-chat-change', group)">
                {{group.name}}
            </li>
        </ul>
    </div>
    `,
});