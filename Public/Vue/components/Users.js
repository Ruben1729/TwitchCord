export default Vue.component('users', {
    components: {
        VueContext
    },
    props: {
        channel_name: String,
        channel_id: Number,
    },
    data: function () {
        return {
            users: {},
        }
    },
    watch: {
        channel_name: function () {
            setTimeout(() => {
                this.getUsers();
            }, 200)
        },
    },
    methods: {
        getUsers: async function () {
            if (this.channel_name) {
                axios.get('/Community/GetUsersFromChannel/' + this.channel_id)
                    .then(response => {
                        let data = response.data;
                        let _users = {};
                        for (let i = 0; i < data.length; i++) {
                            _users[data[i].user_id] = data[i];
                        }
                        this.users = _users;
                    })
                    .then(() => {
                        this.$socket.emit('get_online', this.channel_name);
                    });
            }
        },
        kick(target, data) {
            console.log('kicking user');
        },
        ban(target, data) {
            console.log('banning user');
            console.log(data);
        },
    },
    sockets: {
        online_users: function (online) {
            for (let id in online) {
                console.log(id);
                console.log(this.users[id]);
                if (this.users[id]) {
                    this.users[id].isActive = true;
                }
            };
        },
        user_status_change(info) {
            this.users.forEach
        },
    },
    template: `
    <div id="users-bar">
        <ul>
            <li v-for="user in users" @contextmenu.prevent="$refs.menu.open($event, user)" 
                :class="['user', user.isActive ? 'active' : '']">
                {{user.username}}
            </li>
        </ul>

        <vue-context ref="menu">
            <ul slot-scope="child">
                <li @click="kick($event.target, child.data)">Kick</li>
                <li @click="ban($event.target, child.data)">Ban</li>
            </ul>
        </vue-context>
    </div>
    `,
});