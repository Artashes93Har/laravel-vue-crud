<template>
    <div>
        <div
            class="w-7/12 m-auto overflow-x-auto overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-6xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none ">
                    <!--header-->
                    <div
                        class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t bg-blue-200">
                        <h3 class="text-2xl text-gray-500 font-bold">
                            Edit Product
                        </h3>
                        <button
                            class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                            @click="$emit('close')">
                            <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                            </span>
                        </button>
                    </div>
                    <!--body-->
                    <Form :validation-schema="schema" v-slot="{ errors }" @submit="updateProduct">
                    <div class="relative p-6 flex-auto bg-blue-200">
                        <div>
                            <Field  type="text"
                                   id="name"
                                   name="name"
                                   class="bg-gray-50
                                    border border-gray-300
                                    text-gray-900
                                    text-sm rounded-lg
                                    focus:ring-blue-500
                                    focus:border-blue-500 block w-full p-2.5
                                    dark:bg-gray-700 dark:border-gray-600
                                    dark:placeholder-gray-400 dark:text-white
                                    dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Name"
                                   v-model="product.name"
                                   :class= "{ 'is-invalid': errors.name}">
                            </Field>
                            <div class="invalid-feedback ">{{ errors.name }}</div>
                            <Field type="text"
                                   name = "price"
                                   class="bg-gray-50
                                    border border-gray-300
                                    text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                                    block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                     dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1"
                                   placeholder="price"
                                   v-model="product.price"
                                   :class="{ 'is-invalid': errors.price}"
                            >
                            </Field>
                            <div class="invalid-feedback ">{{ errors.price }}</div>
                            <Field id="categories"
                                   name="category"
                                   as="select"
                                   v-model="product.category.id"
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
                            type="button" v-on:click="$emit('close')">
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
        <div  class="opacity-70 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
import {Form, Field} from 'vee-validate';
import * as yup from "yup";

export default {
    name: "EditProductModal",
    components: {
        Form,
        Field
    },

    props: [
        'product',
        'categories'
    ],

    data() {
        return {
            showModal: false
        }
    },

    computed: {
        schema() {
            return yup.object().shape({
                name: yup.string()
                    .max(35, "Name should not exceed 35 characters")
                    .required("Name is required"),
                price: yup.string()
                    .required("Please enter the required field")
                   // .matches(/^[0-9](\.[0-9][0-9][0-9])$/, "Only number are allowed for this field example 1.111")
            });
        },
    },

    methods: {
        updateProduct: function() {
            // this.product.category_id = this.product.category.id;
            axios.post('/edit-product', this.product)
                .then(res => {
                    if (res.data.status)
                        this.$emit('updateProduct', res.data.product);
                })
                .catch(
                    error => {
                        console.log('error here');
                    })
        }
    }
}
</script>

<style scoped>

</style>

