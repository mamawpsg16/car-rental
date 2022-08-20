<script setup>
const emit = defineEmits(['update:modelValue'])

const props = defineProps({
    modelValue:{
        type:[String,Date,Number]
    },
    type:{
        type:String
    },
    id:{
        type:String   
    },
    disabled:{
        type:Boolean,
        default:false
    },
    placeholder:{
        type:String
    },
    label:{
        type:String
    },
    error:{
        type:String
    }
})
const handleButtonClick = () =>{
    emit('update:modelValue',props.modelValue)
}
</script>

<template lang="">
    <div>
      <label class="text-base font-medium text-gray-700">{{ props.label }}</label>
        <input
        v-model="modelValue"
        :type="props.type"
        autocomplete="id"
        @input="handleButtonClick"
        :disabled="props.disabled"
        :class="{ 'border-red-400': error }"
        class="peer ring-0 outline-none border-2 mb-2 p-3 placeholder-transparent rounded-lg w-full border-gray-400 dark:border-gray-600 text-gray-900 bg-transparent focus:border-blue-500"
        />
        <p v-if="error" class="text-sm text-red-500">{{ error }}</p>
    </div>
</template>