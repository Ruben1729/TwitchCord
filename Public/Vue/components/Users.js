export default Vue.component('users', {
    props: {
        channel_name: String,
        channel_id: Number,
    },
    data: function () {
        return {
            users: [],
        }
    },
    watch: {
        channel_name: function () {
            //Plz don't hurt me UwU
            setTimeout(() => {
                this.getUsers();
                this.$socket.emit('get_online', this.channel_name);
            }, 200)
        },
    },
    methods: {
        getUsers: function () {
            if (this.channel_name) {
                axios.get('/Community/GetUsersFromChannel/' + this.channel_id)
                    .then(response => {
                        this.users = response.data;
                    });
            }
        },
    },
    sockets: {
        online_users: function (online) {
            this.users.forEach(element => {
                if (online[element.user_id]) {
                    element.isActive = true;
                }
            });
        },
        user_status_change(info) {
            this.users.forEach
        },
    },
    template: `
    <div id="users-bar">
        <ul>
            <li v-for="user in users">
                <template v-if="user.isActive">
                    Active: {{user.username}}
                </template>
                <template v-else>
                    {{user.username}}
                </template>
            </li>
        </ul>
    </div>
    `,
});