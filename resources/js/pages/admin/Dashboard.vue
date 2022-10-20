<template>
    <div>
        <div class="overflow-x-auto relative py-10">
            <h2 class="text-2xl text-gray-500 font-bold">PRODUCTS</h2>
            <div v-if="Object.values(products).length">
            <table class="table text-gray-400 border-separate space-y-6 text-sm">
                <thead class="bg-blue-600 text-white">
                <tr>
                    <th scope="col" class="p-3">
                        Category Name
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Name
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Price
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Status
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Created Date
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Approve / Reject
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, key) in products.data" class="bg-blue-200 lg:text-black">
                    <td class="p-3 font-medium capitalize">{{ product.category.name }}</td>
                    <td class="py-3 text-left">{{ product.name }}</td>
                    <td class="py-3 text-left">{{ product.price }}</td>
                    <td class="py-3 text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">
                        <span
                            :class="product.status === 'pending' ? 'bg-yellow-500' : product.status === 'reject' ? 'bg-red-500' : 'bg-green-400'"
                            class="text-white rounded w-[80px] d-block text-center "
                        >
                            {{ product.status }}
                        </span>
                    </td>
                    <td class="py-3 px-6">{{ product.created_at }}</td>
                    <td>
                        <button
                            v-if="product.status === 'reject' || product.status === 'pending'"
                            class="btn btn-success btn-sm "
                            @click="changeStatus(product, 'approve')"
                        >
                            Approve
                        </button>
                        <button
                            v-if="product.status === 'approve' || product.status === 'pending'"
                            class="btn btn-danger btn-sm"
                            @click="changeStatus(product, 'reject')"
                        >
                            Reject
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="products.links.length > 3">
                <div class="mt-10 flex justify-center mt-8">
                    <template v-for="(link, key) in products.links" :key="key">
                        <div
                            v-if="link.url === null"
                            class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                            v-html="link.label"
                        />
                        <button
                            v-else
                            @click="postProducts(link.url)"
                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                            :class="{ 'bg-blue-700 text-white': link.active }"
                            v-html="link.label"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
        </div>
    </div>


</template>

<script>
export default {
    name: "AdminDashboard",

    data() {
        return {
            products: {},
            productsList:{},
        }
    },

    methods: {
        changeStatus(product, status) {
            const data = {
                id: product.id,
                status: status
            }
            axios.post('/change-status', data)
                .then(res => {
                    product.status = status;
                })
                .catch(
                    error => {
                        console.log('error here');
                    })
        },

        postProducts(link = null) {
            axios.get(link ?? '/post-products')
                .then(res => {
                this.products = res.data.products;
            });
        },
    },

    created() {
         this.productsList = this.products
         this.postProducts();
    }
}
</script>

<style scoped>

</style>
