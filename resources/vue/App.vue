<script setup>
import {onMounted, reactive, ref} from "vue";

import axios from "./plugins/axios.js";

import {getURLParameters, setURLParameters} from "./helpers/functions.js";

const estates = ref([])

const formRef = ref()

const form = reactive({
    name: '',
    price: [],
    bedrooms: '',
    bathrooms: '',
    storeys: '',
    garages: '',
    is_loading: false,
})

const rules = {
    bedrooms: [{type: 'number', message: 'The field must be an integer.', trigger: 'blur'}],
    bathrooms: [{type: 'number', message: 'The field must be an integer.', trigger: 'blur'}],
    storeys: [{type: 'number', message: 'The field must be an integer.', trigger: 'blur'}],
    garages: [{type: 'number', message: 'The field must be an integer.', trigger: 'blur'}],
}

const price = reactive({
    min: 0,
    max: 0,
})

const getEstates = async () => {
    form.is_loading = true

    const params = {}

    const fields = ['name', 'bedrooms', 'bathrooms', 'storeys', 'garages']

    fields.forEach(field => {
        if (form[field]) {
            params[field] = form[field]
        }
    });

    if (form.price.length) {
        params.price_min = form.price[0]
        params.price_max = form.price[1]
    }

    if (Object.keys(params).length) {
        setURLParameters(params)
    }

    await axios.get('estates', {params})
        .then(response => response.data)
        .then(response => {
            estates.value = response.data
        })
        .finally(() => {
            form.is_loading = false
        })
}

const getMinAndMaxPrice = async () => {
    await axios.get('estates/get_min_and_max_price')
        .then(response => response.data)
        .then(response => {
            const {min, max} = response

            if (min !== 0 && max !== 0) {
                price.min = Number(min)
                price.max = Number(max)
            }
        })
}

onMounted(async () => {
    const params = getURLParameters()

    const fields = ['name', 'bedrooms', 'bathrooms', 'storeys', 'garages'];

    fields.forEach(field => {
        if (params.hasOwnProperty(field)) {
            form[field] = params[field];
        }
    });

    if (params.hasOwnProperty('price_min') && params.hasOwnProperty('price_max')) {
        form.price = [Number(params.price_min), Number(params.price_max)]

        price.min = Number(params.price_min)
        price.max = Number(params.price_max)
    }

    await getMinAndMaxPrice()
    await getEstates()

    if (!form.price.length) {
        form.price = [price.min, price.max]
    }
})

const submit = async (formEl) => {
    if (!formEl) return

    let isValid = true

    await formEl.validate((valid) => {
        if (!valid) {
            isValid = false

            return false
        }
    })

    if (isValid) {
        await getEstates()
    }
}

const reset = async () => {
    form.name = ''
    form.price = [price.min, price.max]
    form.bedrooms = ''
    form.bathrooms = ''
    form.storeys = ''
    form.garages = ''

    await getEstates()
}
</script>

<template>
    <el-container class="container">
        <el-card>
            <el-form
                ref="formRef"
                :model="form"
                label-position="left"
                label-width="100px"
            >
                <el-form-item label="Name" prop="name">
                    <el-input v-model="form.name"/>
                </el-form-item>
                <el-form-item label="Price" prop="price">
                    <el-slider v-model="form.price" range :min="price.min" :max="price.max"/>
                </el-form-item>
                <el-form-item label="Bedrooms" prop="bedrooms" :rules="rules.bedrooms">
                    <el-input v-model.number="form.bedrooms"/>
                </el-form-item>
                <el-form-item label="Bathrooms" prop="bathrooms" :rules="rules.bathrooms">
                    <el-input v-model.number="form.bathrooms"/>
                </el-form-item>
                <el-form-item label="Storeys" prop="storeys" :rules="rules.storeys">
                    <el-input v-model.number="form.storeys"/>
                </el-form-item>
                <el-form-item label="Garages" prop="garages" :rules="rules.garages">
                    <el-input v-model.number="form.garages"/>
                </el-form-item>
                <div class="buttons">
                    <el-button type="primary" @click="submit(formRef)">Submit</el-button>
                    <el-button type="danger" @click="reset">Reset</el-button>
                </div>
            </el-form>
        </el-card>
        <el-card>
            <el-table v-loading="form.is_loading" :data="estates" style="width: 100%">
                <el-table-column prop="name" label="Name" width="180"/>
                <el-table-column prop="price" label="Price"/>
                <el-table-column prop="bedrooms" label="Bedrooms"/>
                <el-table-column prop="bathrooms" label="Bathrooms"/>
                <el-table-column prop="storeys" label="Storeys"/>
                <el-table-column prop="garages" label="Garages"/>
            </el-table>
        </el-card>
    </el-container>
</template>

<style>
.container {
    width: 50vw;
    margin: 100px auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.buttons {
    width: 100%;
    display: flex;
    justify-content: center;
}

.buttons > * {
    width: 100px;
}
</style>
