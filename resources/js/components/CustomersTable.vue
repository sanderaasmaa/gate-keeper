<template>
    <div class="container m-3">
        <div class="row m-2">
            <div class="row">
                <button @click="editService" type="button" class="btn btn-primary btn-lg mr-1">Edit services</button>
                <button @click="editService" type="button" class="btn btn-secondary btn-lg">Edit service passes</button>
            </div>
        </div>
        <div class="row m-2">
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
                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <button v-for="service in services"
                                        @click="useService(customer, service.id)"
                                        type="button" class="btn btn-outline-primary">
                                    {{ service.name }}
                                </button>
                            </div>
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
            <service-selector-modal :title="getModalTitle()">
                <div v-if="Object.keys(activeCustomer).length" class="btn-toolbar mb-2" v-for="service in services">
                    <div class="btn-group">
                        <button v-for="pass in service.passes"
                                @click="assignPass(pass)"
                                type="button" class="btn btn-outline-primary">
                            {{ pass.name }}
                        </button>
                    </div>
                </div>
                <div v-else>
                    <h1>Under construction</h1>
                    <p>Use api calls for now</p>
                </div>
            </service-selector-modal>
        </div>
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
            modal: '',
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
        editService() {
            this.activeCustomer = {};
            $('#add_service-modal').modal('show');
        },
        addServiceSelector(customer) {
            this.activeCustomer = customer;
            $('#add_service-modal').modal('show');
        },
        assignPass(pass) {
            const customer = this.activeCustomer;
            axios.post('api/assign', {
                customer: customer.id,
                pass: pass.id
            }).then(({data}) => {
                $('#add_service-modal').modal('hide');
                this.activeCustomer = {};
                if (data.success) {
                    this.$toast.success(customer.name + ' - ' + pass.name + ' - ' + data.message);
                    return;
                }
                this.$toast.error(customer.name + ' - ' + data.message);
            });
        },
        getModalTitle() {
            return this.activeCustomer.name;
        }
    }
}
</script>
