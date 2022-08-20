<script setup>
import { onMounted,ref } from 'vue';
  /** PROPS */
  const props = defineProps({
    persistent: {
      type: Boolean,
      default: false,
    },
    data:{
      type:Object,
      default:null
    }
  });
  /** EDIT CONFIG */
  // const editConfiguration = () =>{
  //   console.log('edit');
  // }

  /** EMIT */
  const emit = defineEmits(['close']);
  const emitClose = () => {
    if (props.persistent) return;
    emit('close');
  };
  // const editModal = () => {
  //   console.log('edit')
  //     emit('update:modelValue',true);
  // }
  onMounted(()=>{
  })
</script>

<template>
  <Teleport to="body">
    <div class="inset-0 fixed overflow-y-auto flex justify-center items-center z-50" v-bind="$attrs">
      <div @click.prevent="emitClose" class="fixed inset-0 w-full flex min-h-screen justify-center items-center bg-gray-700/50 z-40"></div>
      <div class="flex w-full px-4 sm:px-0">
        <Transition>
          <div class="mx-auto min-w-full  sm:min-w-[468px] md:min-w-[568px] bg-white box-shadow-lg rounded-lg min-w-2xl z-40 inset-0">
            <div v-if="data === null">
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
            <div v-else>
              <div class="px-5 pt-5 pb-3 font-bold">
                {{data.name}}
              </div>
              <div class="px-5 pb-2">
                <div class="flex justify-center mt-2">
                    <div class="w-36 rounded h-28  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                        <img :src="`images/car-images/${data.image}`" class="object-fit  h-full" alt="" />
                    </div>
                </div>
                <div class="mt-5">
                  <p class="flex  justify-center">{{data.name}}</p>
                  <p class="flex  justify-center">{{data.details}}</p>
                </div>
              </div>
              <div class="flex justify-end px-5 py-4">
                 <button @click="editModal" class="text-base bg-blue-600 rounded-lg py-2 px-4 mt-2 hover:bg-blue-700  rounded-md text-white text-base tracking-wider uppercase font-medium hover:cursor-pointer"> Edit </button>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </div>
  </Teleport>
</template>

<style>
  /* we will explain what these classes do next! */
  .v-enter-active,
  .v-leave-active {
    transition: opacity 0.5s ease;
  }

  .v-enter-from,
  .v-leave-to {
    opacity: 0;
  }
</style>
