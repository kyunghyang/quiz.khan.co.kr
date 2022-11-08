<template>
    <div>
        <slot />

        <flash />
    </div>

</template>
<script>
import ShoppingHeader from "../Components/ShoppingHeader";
import BrandHeader from "../Components/BrandHeader";
import FooterVue from "../Components/Footer";
import Flash from "../Components/Flash";
export default {
    components: {BrandHeader, ShoppingHeader, FooterVue, Flash},
    data(){
        return {
            pathname: location.pathname,
        }
    },

    mounted() {
        $("#app").click(function(){
            setTimeout(function(){
                window.parent.postMessage({ height : $("#app").height() }, "*");
            }, 300);
        });

        window.parent.postMessage({ height : $("#app").height() }, "*");

        this.$inertia.on("start", () => {
            window.parent.postMessage({ height : $("#app").height() }, "*");
        });
    }
}
</script>
