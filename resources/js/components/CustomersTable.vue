<template>
    <table class="table">
        <thead>
        <tr>
            <th>name</th>
            <th>email</th>
            <th>services</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="customer in customers" :key="customer.id">
            <td>{{ customer.name }}</td>
            <td>{{ customer.email }}</td>
            <td>
                <div>
                    <button v-for="service in services" @click="useService(customer.id, service.id)" type="button" class="btn btn-outline-primary">
                        {{ service.name }}
                    </button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "Table",
    data() {
        return {
            services: {},
            customers: {},
        }
    },
    created() {
        this.getServices()
        this.getCustomers()
        this.$toast.error("I'm a toast!");

// Or with options
        this.$toast.success("My toast content", {
            timeout: 2000
        });
    },
    methods: {
        getCustomers() {
            axios.get('api/customers').then(({data}) => (this.customers = data.data));
        },
        getServices: function () {
            axios.get('api/services').then(({data}) => (this.services = data.data));
        },
        useService(customer, service) {
            axios.patch(`api/customer/${customer}/access/${service}`).then(({data}) => {
                if (data.success) {
                    this.$toast.success(data.message);
                    return;
                }
                this.$toast.error(data.message);
            });
        }
    }
}
</script>
