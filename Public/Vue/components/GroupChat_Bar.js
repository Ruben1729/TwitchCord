export default Vue.component('groupchat-bar', {
    props: {
        channel_id: Number,
    },
    data: function () {
        return {
            groups: [],
        }
    },
    watch: {
        channel_id(val) {
            if (val) {
                this.fetchGroups();
            }
        }
    },
    methods: {
        fetchGroups() {
            axios.get('/Community/GetGroupChats/' + this.channel_id)
                .then(response => {
                    let data = response.data;
                    this.groups = data.groups;
                    this.$emit('group-change', this.groups[0]);
                })
                .catch(response => {
                    console.log('Invalid Request: ' + response.data.error);
                })
        },
    },
    template: `
    <div id="group-bar">
        <button 
        id="stream-button"
        @click="$emit('stream-state', true)">Stream</button>

        <ul>
            <li class="group-item"
            v-for="group in groups" :key="group.group_chat_id"
            @click="$emit('group-change', group)">
                {{group.name}}
            </li>
        </ul>
    </div>
    `,
});