<script setup>
  /** UPDATE CONFIG */
  const updateConfiguration = () =>{
    form.patch(route('configuration.update',form.id),{
      onSuccess: (response) => {
        toast.success('Config updated successfully!');
        form.reset()
      },
      onError: (error) => {
        toast.error('Something went wrong!');
      },
    })
  }
</script>
<template lang="">
    <Modal v-if="isEditModalShown" @close="toggleEditModal">
        <template v-slot:title>
            <p class="font-bold text-xl">Update Configuration</p>
        </template>
        <template v-slot:body>
            <form action="" class="mt-2">
                <div class="flex justify-center mt-2">
                    <div class="w-36 rounded h-24  border-2 border-gray-400 flex items-center justify-center shadow-md overflow-hidden">
                        <img v-if="form.image_preview" :src="form.image_preview" class="object-fit  h-full" alt="" />
                        <img v-else :src="`images/car-images/${form.image}`" class="object-fit  h-full" alt="" />
                    </div>
                </div>
                    <p v-if="errors.image" class="text-sm flex justify-center text-red-500 mt-2">{{ errors.image }}</p>
                <div>
                    <div class="flex justify-center">
                        <input id="avatar" type="file" @change="imageSelected" class="hidden" accept="image/*" />
                        <label for="avatar" class="px-3 py-2 hover:bg-blue-700 bg-blue-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mr-2 mt-2 ">Upload Image</label>
                        <button type="submit" class="px-3 py-2 hover:bg-red-700 bg-red-600 rounded-md text-white text-xs tracking-wider uppercase font-medium hover:cursor-pointer mt-2" size="sm" @click="resetUploadedImage" :disabled="!form.image_preview">Reset Image</button>
                    </div>
                </div>
                    <div class="container flex flex-col px-4 space-y-5 justify-center mt-10">

                    <FormInput id="name" v-model="form.name" name="name" type="text" placeholder="Enter name" label="Name" :error="errors.name"/>

                    <FormInput id="fee" v-model="form.fee" name="fee" type="number" placeholder="Enter fee" label="Fee" :error="errors.fee"/>

                        <FormTextArea id="details" v-model="form.details" placeholder="Enter details" label="Details" :error="errors.details"/>

                    </div>
            </form>
        </template>
        <template v-slot:footer>
                <button type="submit" class="mr-2 px-3 py-2 border-2 border-black  text-black rounded-md text-base tracking-wider uppercase font-medium  hover:cursor-pointer mt-2" size="sm" @click.prevent="cancelEditModal">Cancel</button>
                <button type="submit" class="px-3 py-2  bg-blue-700 text-white rounded-md text-base tracking-wider uppercase font-medium  hover:cursor-pointer mt-2" size="sm" @click.prevent="updateConfiguration" :disabled="form.processing">Update</button>
        </template>
    </Modal>
</template>
