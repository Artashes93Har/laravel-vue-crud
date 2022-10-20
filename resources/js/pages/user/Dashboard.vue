
<template>
    <div class="flex justify-end">
        <button type="button"
                class="  px-4 py-2 rounded-md bg-green-500 text-sky-100 hover:bg-blue-600"
                @click="openAddCategoryModal = !openAddCategoryModal">Add Category
        </button>
    </div>
    <div class="overflow-x-auto relative ">
        <h2 class="text-2xl text-gray-500 font-bold">CATEGORY</h2>
        <div v-if="Object.values(categories).length ">

            <table class="table text-gray-400 border-separate space-y-6 text-sm ">
                <thead class="bg-blue-600 text-white">
                <tr>
                    <th scope="col" class="p-3  ">
                        Name
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Description
                    </th>
                    <th scope="col" class="p-3 text-left  ">
                        Status
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Created Date
                    </th>
                    <th scope="col" class="p-3 text-left ">
                        Edit / Delete
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category in categories.data" class="bg-blue-200 lg:text-black ">
                    <td  class="p-3 font-medium capitalize ">{{ category.name }}</td>
                    <td  class="p-3 text-left">{{ category.description }}</td>
                    <td  class="p-3 text-left">
                    <span class="bg-green-400 text-gray-50 rounded-md px-2 w-[80px] d-block text-center">
                        {{ category.status }}
                    </span>
                    </td>
                    <td  class="p-3 text-left">{{ category.created_at }}</td>
                    <td>
                        <button class="btn btn-success btn-sm bg-green-400" @click="selectedCategory = category; openEditCategoryModal=!openEditCategoryModal">Edit</button>
                        <button class="btn btn-danger btn-sm bg-red-500 " @click="deleteCategoryModal(category.id)">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div v-if="categories.links.length > 3 ">
                <div class="mt-10 flex justify-center mt-8">
                    <template v-for="(link, key) in categories.links" :key="key">
                        <div
                            v-if="link.url === null"
                            v-html="link.label"
                            class="py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full
                                   text-gray-500 pointer-events-none focus:shadow-none"
                        />
                        <button
                            v-else
                            @click="getCategories(link.url)"
                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-blue-400 focus:border-primary focus:text-primary"
                            :class="{ 'bg-blue-700 text-white': link.active }"
                            v-html="link.label"
                        ></button>
                    </template>
                </div>
            </div>
            <div v-else>
                Loading...
            </div>
        </div>

        <AddCategories
            v-if="openAddCategoryModal"
            @addCategory="addCategory"
            @close="openAddCategoryModal = false"
        >
        </AddCategories>
        <EditCategoryModal
            v-if="openEditCategoryModal"
            :category="selectedCategory"
            @close="openEditCategoryModal = false"
            @updateCategory="updateCategory"
        ></EditCategoryModal>
        <DeleteCategoryModal
            v-if="openDeleteCategoryModal"
            :id="selectedCategoryId"
            :current_page="categories.current_page"
            @close="openDeleteCategoryModal = false"
            @deleteCategory="deleteCategory">
        </DeleteCategoryModal>
    </div>
    <div class="flex justify-end ">
        <button type="button"
                class="  px-4 py-2 rounded-md bg-green-500 text-sky-100 hover:bg-blue-600"
                @click="openAddProductsModal = !openAddProductsModal">Add Product
        </button>
    </div>
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
                        Edit / Delete
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(product, key) in products.data" class="bg-blue-200 lg:text-black">
                    <td class="p-3 font-medium capitalize ">{{ product.category.name}}</td>
                    <td class="p-3 text-left">{{ product.name }}</td>
                    <td class="p-3 text-left">{{ product.price}}</td>
                    <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap">
                    <span :class="product.status === 'pending' ? 'bg-yellow-500' : product.status === 'reject' ? 'bg-red-500' : 'bg-green-400'"
                          class=" text-white rounded w-[80px] d-block text-center"
                    >
                        {{ product.status }}
                    </span>
                    </td>
                    <td class="text-sm text-gray-900 font-medium px-6 py-4 whitespace-nowrap ">{{ product.created_at }}</td>
                    <td>
                        <button class="btn btn-success btn-sm bg-green-400"  @click="selectedProduct = product; openEditProductModal=!openEditProductModal"  >Edit</button>
                        <button class="btn btn-danger btn-sm bg-red-500" @click="deleteProductModal(product.id)">Delete</button>
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
                            @click="getProducts(link.url)"
                            class="mr-1 mb-1 px-2 py-1 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                            :class="{ 'bg-blue-700 text-white': link.active }"
                            v-html="link.label"
                        ></button>
                    </template>
                </div>
            </div>
        </div>

    </div>
    <AddProducts
        v-if="openAddProductsModal"
        @addProduct="addProduct"
        @close="openAddProductsModal = false"
        :categories="categoryList"
    ></AddProducts>
    <EditProductModal
        v-if="openEditProductModal"
        :product="selectedProduct"
        :categories="categoryList"
        @close="openEditProductModal = false"
        @updateProduct="updateProduct"
    ></EditProductModal>
    <DeleteProductModal
        v-if="openDeleteProductModal"
        :id="selectedProductId"
        :current_page="products.current_page"
        @close="openDeleteProductModal = false"
        @deleteProduct="deleteProduct">
    </DeleteProductModal>
</template>

<script>

import AddCategories from "./AddCategories.vue";
import AddProducts from "./AddProducts.vue";
import DeleteProductModal from "../../components/Delete/DeleteProductModal.vue";
import DeleteCategoryModal from "../../components/Delete/DeleteCategoryModal.vue";
import EditCategoryModal from "../../components/Edit/EditCategoryModal.vue";
import EditProductModal from "../../components/Edit/EditProductModal.vue";


export default {
    name: "UserDashboard",
    components: {
        AddCategories,
        AddProducts,
        DeleteProductModal,
        DeleteCategoryModal,
        EditCategoryModal,
        EditProductModal,
    },

    data() {
        return {
            selectedProductId: null,
            selectedCategoryId: null,
            selectedCategory: null,
            selectedProduct:null,
            openDeleteProductModal: false,
            openDeleteCategoryModal: false,
            openAddCategoryModal:false,
            openAddProductsModal:false,
            openEditCategoryModal:false,
            openEditProductModal:false,
            productsList: {},
            categories: {},
            products: {},
            categoryList: []
        }
    },

    methods: {

        getCategories(link = null) {
            axios.get(link ?? '/get-categories').then(res => {
                this.categories = res.data.categories;
            });
        },

        getProducts(link = null) {
            axios.get(link ?? '/get-products').then(res => {
                this.products = res.data.products;
            });
        },

        getCategoryList() {
            axios.get('/get-category-list').then(res => {
                this.categoryList = res.data.category_list;
            });
        },

        deleteProduct(product) {
            this.products.data.forEach((item, index) => {
                if (item.id === this.selectedProductId) {
                    this.products.data.splice(index, 1);
                }
            });

            if (this.products.data.length === 4) {
                if (product)
                    this.products.data.push(product);
            }
            this.products.total--;
            const perPage = Math.ceil(this.products.total / 5);
            if (perPage < (this.products.links.length - 2)) {
                this.products.links.splice(this.products.links.length - 2, 1);
            }
            if (this.products.current_page) {
                if (this.products.data.length === 0){
                    const pages = this.products.current_page - 1;
                    this.getProducts('/get-products?page=' + pages);
                }
            }
            this.openDeleteProductModal = false;
        },

        deleteProductModal(id) {
            this.openDeleteProductModal = true;
            this.selectedProductId = id;
        },


        deleteCategory(category) {
            this.categories.data.forEach((item, index) => {
                if (item.id === this.selectedCategoryId) {
                    this.categories.data.splice(index, 1);
                }
            });
            if (this.categories.data.length === 4) {
                if (category)
                    this.categories.data.push(category);
            }
            this.categories.total--;
            const perPage = Math.ceil(this.categories.total / 5);
            if (perPage < (this.categories.links.length - 2)) {
                this.categories.links.splice(this.categories.links.length - 2, 1);
            }
            if (this.categories.current_page) {
                if (this.categories.data.length === 0){
                    const pages = this.categories.current_page - 1;
                    this.getCategories('/get-categories?page=' + pages);
                }
            }
            this.openDeleteCategoryModal = false;
        },

        deleteCategoryModal(id) {
            this.openDeleteCategoryModal = true;
            this.selectedCategoryId = id;
        },

        addCategory(param) {
            if(this.categories.current_page === 1){
                this.categories.data.unshift(param);
            }
            if (this.categories.data.length > 5) {
                this.categories.data.pop();
            }
            this.categories.total++;

            const pagesCount = Math.ceil(this.categories.total / 5);

            if (pagesCount > (this.categories.links.length -2)) {
                const link = {
                    url: window.location.origin +'/get-categories?page=' + pagesCount,
                    label: pagesCount,
                    active: false
                };
                this.categories.links.splice(this.categories.links.length - 1, 0, link);
            }
            this.openAddCategoryModal = false;
            this.getCategoryList();
        },

        addProduct(param) {
            if(this.products.current_page === 1){
                this.products.data.unshift(param);
            }
            if (this.products.data.length > 5) {
                this.products.data.pop();
            }
            this.products.total++;

            const pagesCount = Math.ceil(this.products.total / 5);

            if (pagesCount > (this.products.links.length -2)) {
                const link = {
                    url: window.location.origin +'/get-products?page=' + pagesCount,
                    label: pagesCount,
                    active: false
                };
                this.products.links.splice(this.products.links.length - 1, 0, link);
            }
            this.openAddProductsModal = false;
        },

        updateCategory(param) {
            this.selectedCategory = param;
            this.openEditCategoryModal= false;
        },

        updateProduct(param) {
            this.selectedProduct = param;
            this.selectedProduct.category = param.category;
            this.openEditProductModal= false;
        }
    },


    created() {
         this.productsList = this.products
            this.getCategories();
            this.getProducts();
            this.getCategoryList()

        }

}
</script>

<style scoped>

</style>
