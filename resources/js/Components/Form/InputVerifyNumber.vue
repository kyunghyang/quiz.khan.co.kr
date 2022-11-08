<template>
    <div>
        <div class="col-group" v-if="mode === 'beforeSend'">
            <div class="m-input m-input-text type01">
                <input type="text" v-model="form.contact" @keyup="clearLetter" placeholder="- 없이 숫자만">
            </div>

            <button type="button" class="m-input-btn" @click="store">인증번호발송</button>
        </div>
        <div v-if="mode === 'afterSend'">
            <div class="m-input-withBtn type02" v-if="mode === 'afterSend'">
                <div class="m-input m-input-text type01">
                    <input type="text" v-model="form.number" @keyup="clearLetter" placeholder="인증번호">
                </div>

                <button type="button" class="m-input-btn" @click="update">인증하기</button>
            </div>
        </div>
        <div class="col-group" v-if="mode === 'verified'">
            <div class="m-input m-input-text type01">
                <input type="text" v-model="form.contact" @keyup="clearLetter" disabled>
            </div>
        </div>

        <p class="m-input-error">{{form.errors.contact}}</p>
        <p class="m-input-error">{{form.errors.number}}</p>
    </div>
</template>
<script>


export default {
    props: {
        url: {
            default: "/verifyNumbers"
        }
    },

    data(){
        return {
            form: this.$inertia.form({
                contact: "",
                number: ""
            }),

            mode: "beforeSend",
        }
    },

    methods: {
        store(){
            this.form.post(this.url, {
                onSuccess: (response) => {
                    this.mode = "afterSend";
                },
                preserveScroll: true
            });
        },

        update(){
            this.form.patch(this.url, {
                preserveScroll: true,
                onSuccess: (response) => {
                    if(!this.$page.props.flash.error){
                        this.$emit("verified", this.form.contact);
                        this.mode = "verified";
                    }
                }
            })
        },

        clearLetter(){
            this.form.contact = this.form.contact.replace(/-/g, '');
        },
    }
}
</script>
