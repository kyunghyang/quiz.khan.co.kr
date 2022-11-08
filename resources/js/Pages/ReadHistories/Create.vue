<template>

</template>
<style>
</style>
<script>
import {Link} from '@inertiajs/inertia-vue';
import Pagination from "../../Components/Pagination";

export default {
    components: {Link, Pagination},

    data(){
        return {
            form: this.$inertia.form({
                page: 1,
                url: "",
                count_text: "",
                category: "",
                title: "",
                description: "",
                img_url: ""
            })
        }
    },

    methods:{
        store(){
            this.form.post("/readHistories", {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    this.items = page.props.items;
                }
            });
        },
    },

    mounted() {



    }
}
</script>
