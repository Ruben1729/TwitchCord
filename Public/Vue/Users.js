export default Vue.component('users', {
    props: {
        channel: Object,
    },
    data: function () {
        return {
            users: [],
            css: {

            },
        }
    },
    methods: {
        getUsers: function () {
            if (this.channel) {
                let vm = this;
                axios.get('/Community/GetUsersFromChannel/' + this.channel.channel_id)
                    .then(function (response) {
                        vm.users = response.data;
                    })
                    .catch(function (response) {

                    });
            }
        },
        getActiveId: function () {

        }
    },
    mounted: function () {

    },
    watch: {
        channel: function () {
            this.getUsers();
        },
        users: function () {
            this.$socket.emit('get_online', this.channel.channel_id);
        }
    },
    sockets: {
        online_users: function (online) {
            this.users.forEach(element => {
                if (online[element.user_id]) {
                    element.isActive = true;
                }
            });
        }
    },
    template: `
    <div :style="css.bar">
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