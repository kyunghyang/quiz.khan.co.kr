<template>
    <a :href="`/shopping/products/${product.id}`" v-if="type === 'type01'">
        <div class="img-box">
            <img :src="product.img ? product.img.url : ''" alt="">
        </div>
        <div class="txt-box row-group">
            <h5>
                {{ product.title }}
            </h5>
            <div>
                <span class="non-discount-price" v-if="product.value_discount">{{ product.price.toLocaleString() }}</span>
                <p class="discount-price">
                    <span class="discount" v-if="product.value_discount">
                        {{product.type_discount === '비율할인' ? product.value_discount + "%" : "-" + (product.value_discount.toLocaleString())}}
                    </span>
                    <span>{{ product.discounted_price.toLocaleString() }}</span>
                </p>
            </div>
        </div>
        <div class="btn-wrap row-group">
            <div :class="product.isLike ? 'fav-btn active' : 'fav-btn'" @click="(event) => like(event, product)"></div>

            <!--
            <label for="cart_add" @click="addToCart(representProduct)">
                <input type="checkbox" id="cart_add">
                <span class="cart-btn"></span>
            </label>
            -->
        </div>
    </a>
</template>
<script>
import {Link} from '@inertiajs/inertia-vue';

export default {
    components: {Link},
    props : {
        type: {
            default: "type01"
        },
        product: {
            required: true
        }
    },
    data(){
        return {
            likes: this.$page.props.likes,
            likeForm: this.$inertia.form({
                page: 1,
                product_id: ""
            })
        }
    },
    methods:{
        like(event, product){
            event.stopPropagation();
            event.preventDefault();

            this.likeForm.product_id = product.id;

            this.likeForm.post("/likes", {
                preserveScroll: true,
                preserveState: false,
                onSuccess: (page) => {
                    $(event.target).toggleClass("active");
                }
            });
        },
    }
}
</script>
