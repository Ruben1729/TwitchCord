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
        openMenu(e) {
            console.log('test');
            e.preventDefault();
        },
    },
    sockets: {
        online_users: function (online) {
            for (let element in online) {
                if (online[element.user_id]) {
                    element.isActive = true;
                }
            };
        },
        user_status_change(info) {
            this.users.forEach
        },
    },
    template: `
    <div id="users-bar" :contextmenu="openMenu">
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