<template>
    <div>
        <div
             class="w-7/12 m-auto overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none
              focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-6xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none ">
                    <!--header-->
                    <div
                        class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t bg-blue-200">
                        <h3 class="text-3xl font-semibold">
                            Add new Product
                        </h3>
                        <button
                            class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                            @click="$emit('close')">
                            <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            ×
                            </span>
                        </button>
                    </div>
                    <!--body-->
                    <Form :validation-schema="schema" v-slot="{ errors }"  @submit="saveProduct">
                    <div class="relative p-6 flex-auto bg-blue-200">
                        <div>
                            <Field  type="text" id="name"
                                    class="bg-gray-50
                                    border border-gray-300
                                    text-gray-900
                                    text-sm rounded-lg
                                    focus:ring-blue-500
                                    focus:border-blue-500 block w-full p-2.5
                                    dark:bg-gray-700 dark:border-gray-600
                                    dark:placeholder-gray-400 dark:text-white
                                    dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                                    placeholder="Name"
                                    name="name"
                                    v-model="product.name"
                                    :class= "{ 'is-invalid': errors.name}">
                            </Field>
                            <div class="invalid-feedback ">{{ errors.name }}</div>
                                <Field type="number"
                                   class="bg-gray-50 border border-gray-300 text-gray-900
                                   text-sm rounded-lg focus:ring-blue-500
                                    focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700
                                     dark:border-gray-600 dark:placeholder-gray-400
                                     dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"
                                      placeholder="price"
                                       v-model="product.price"
                                       name = "price"
                                       :class="{ 'is-invalid': errors.price}"
                                >
                                </Field>
                            <div class="invalid-feedback ">{{ errors.price }}</div>
                            <Field id="categories"
                                   name="category"
                                   as="select"
                                   v-model="product.category_id"
                                   :class="{ 'is-invalid': errors.category}"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                                   focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-2">
                                <option v-for="category in categories"
                                        :value="category.id"
                                >
                                    {{ category.name }}
                                </option>
                            </Field>
                            <div class="invalid-feedback">{{ errors.category }}</div>

                        </div>
                    </div>

                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b bg-blue-200">
                        <button
                            class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border
                        text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100"
                            type="button" @click="$emit('close')">
                            Close
                        </button>
                        <button
                            class="mb-2 md:mb-0 bg-green-500 border border-green-500 px-5 py-2 text-sm shadow-sm font-medium
                        tracking-wider text-white rounded-full hover:shadow-lg hover:bg-green-600"
                            type="submit">
                            Save Changes
                        </button>
                    </div>
                    </Form>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
import {Form, Field} from 'vee-validate';
import * as yup from "yup";

export default {
    name: "AddProducts",
    emits: ["close", "saveProduct","categories"],
    components: {
        Form,
        Field
    },

    props: [
        'categories'
        ],

    data() {
        return {
            showModal: false,
            categoryId: null,
            product: {
                name: '',
                price: '',
                category_id:'',
            }
        }
    },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .max(35, "Name should not exceed 35 characters")
                    .min(3,"Name should not exceed 3 characters")
                    .required("Name is required"),
                category: yup.string()
                    .required("Тhe category is required. Please choose one of the category."),
                price: yup.string()
                    .required("Please enter the required field")
                    .matches(/^[0-9](\.[0-9][0-9][0-9])$/, "Only number are allowed for this field example 1.111")
            });
        },
    },

    methods: {
        saveProduct: function () {
              // this.product.category_id = this.categoryId
            axios.post('/save-products', this.product)
                .then(res => {
                    this.$emit('addProduct', res.data.product,);
                })
                .catch(error => {console.log('error here');
                    })

        }
    },

}
</script>

<style scoped>

</style>

