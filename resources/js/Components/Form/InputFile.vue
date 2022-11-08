<template>
    <div class="upload">
        <input type="file" id="a" accept="image/*" @change="changeFile">
        <label for="a" style="cursor:pointer;"><i class="xi-upload"></i></label>
        <span>사진 업로드</span>
        <ul class="file-list">
            <li>{{ file.name }}</li>
        </ul>
    </div>
</template>
<script>
export default {
    props: ["default"],

    data(){
        return {
            file: {
                name: ""
            }
        }
    },

    methods: {
        changeFile(event) {
            this.$emit("change", event.target.files[0]);

            this.file = event.target.files[0];
        },
    },

}
</script>
