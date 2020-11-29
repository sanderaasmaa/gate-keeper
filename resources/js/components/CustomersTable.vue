<template>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Services</th>
                <th>Top-up</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="customer in customers" :key="customer.id">
                <td>{{ customer.name }}</td>
                <td>{{ customer.email }}</td>
                <td>
                    <div>
                        <button v-for="service in services"
                                @click="useService(customer, service.id)"
                                type="button" class="btn btn-outline-primary">
                            {{ service.name }}
                        </button>
                    </div>
                </td>
                <td>
                    <div>
                        <button @click="addServiceSelector(customer)"
                                type="button" class="btn btn-outline-success">
                            Add service pass
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <service-selector-modal :title="getActiveCustomerName()">
            <div class="btn-toolbar" v-for="service in services">
                <div class="btn-group">
                    <button v-for="pass in service.passes"
                            @click="assignPass(pass)"
                            type="button" class="btn btn-outline-primary">
                        {{ pass.name }}
                    </button>
                </div>
            </div>
        </service-selector-modal>
    </div>
</template>

<script>
export default {
    name: "Table",
    data() {
        return {
            services: {},
            customers: {},
            activeCustomer: {},
        }
    },
    created() {
        this.getServices()
        this.getCustomers()
    },
    methods: {
        getCustomers() {
            axios.get('api/customers').then(({data}) => (this.customers = data.data));
        },
        getServices: function () {
            axios.get('api/services').then(({data}) => (this.services = data.data));
        },
        useService(customer, service) {
            axios.patch(`api/customer/${customer.id}/access/${service}`).then(({data}) => {
                if (data.success) {
                    this.$toast.success(customer.name + ' - ' + data.message);
                    return;
                }
                this.$toast.error(customer.name + ' - ' + data.message);
            });
        },
        addServiceSelector(customer) {
            this.activeCustomer = customer;
            $('#add_service-modal').modal('show');
            $('#add_service-modal').prop('title', 'asdasdasdas');
        },
        assignPass(pass) {
            const customer = this.activeCustomer;
            axios.post('api/assign', {
                customer: customer.id,
                pass: pass.id
            }).then(({data}) => {
                $('#add_service-modal').modal('hide');
                if (data.success) {
                    this.$toast.success(customer.name + ' - ' + pass.name + ' - ' + data.message);
                    return;
                }
                this.$toast.error(customer.name + ' - ' + data.message);
            });
        },
        getActiveCustomerName() {
            return this.activeCustomer.name;
        }
    }
}
</script>
