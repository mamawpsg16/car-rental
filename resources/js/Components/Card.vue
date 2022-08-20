<script setup>
const props = defineProps({
    cars:{
        type:Object,
        default:null
    },
})
</script>
<template>
    <div class="container columns-3 w-20">
           <div class="px-5 pt-5 pb-3">
              <slot name="title" />
            </div>
            <div class="px-5 pb-2">
              <slot name="body" />
            </div>
            <div class="flex justify-end px-5 py-4">
              <slot name="footer" />
            </div>
    </div>
</template>
