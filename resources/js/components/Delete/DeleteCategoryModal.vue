<template>
    <div class="w-7/12 backdrop-opacity-10 m-auto overflow-x-auto overflow-y-auto fixed inset-0 z-50
                       outline-none focus:outline-none justify-center items-center flex">
        <div class="relative w-auto my-6 mx-auto max-w-6xl ">
            <!--content-->
            <div
                class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                <!--header-->
                <div
                    class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t bg-blue-600">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-xl font-bold py-4 ">Are you sure to delete the Category?</h3>
                </div>
                <!--body-->
                <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b bg-blue-200">
                    <button
                        class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border
                        text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100"
                        type="button" @click="$emit('close')">
                        Close
                    </button>
                    <button
                        class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium
                        tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600"
                        type="button" @click="deleteCategory()">
                        Delete
                    </button>
                </div>
                <!--footer-->
            </div>
        </div>
    </div>
    <div  class="opacity-70 fixed inset-0 z-40 bg-black"></div>
</template>

<script>
export default {
    name: "DeleteCategoryModal",
    emits: ["close", "deleteCategory"],
    props: ['id','current_page'],
    data() {
        return {
            showModal: false,
        }
    },

    methods: {
        deleteCategory() {
            axios.post(`/delete-category/`, {id: this.id, current_page: this.current_page})
                .then((res) => {
                    this.$emit('deleteCategory', res.data.category);
                });
        },
    }
}
</script>

<style scoped>

</style>
