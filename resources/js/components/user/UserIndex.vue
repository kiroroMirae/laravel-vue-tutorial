<template>
    <div class="flex justify-end items-center mt-[24px]">
        <div class="flex gap-x-[8px]">
            <a href="/user/create"
                class="
                    bg-blue-600
                    hover:bg-blue-700
                    text-white
                    font-medium
                    py-2
                    px-4
                    rounded-[8px]
                "
            >
                Create New User
            </a>
            <div class="flex relative">
                <svg class="absolute self-center left-[12px]" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.1665 1.6665C5.02437 1.6665 1.6665 5.02437 1.6665 9.1665C1.6665 13.3086 5.02437 16.6665 9.1665 16.6665C10.9373 16.6665 12.5649 16.0528 13.8479 15.0264L16.9106 18.0891C17.236 18.4145 17.7637 18.4145 18.0891 18.0891C18.4145 17.7637 18.4145 17.236 18.0891 16.9106L15.0264 13.8479C16.0528 12.5649 16.6665 10.9373 16.6665 9.1665C16.6665 5.02437 13.3086 1.6665 9.1665 1.6665ZM3.33317 9.1665C3.33317 5.94484 5.94484 3.33317 9.1665 3.33317C12.3882 3.33317 14.9998 5.94484 14.9998 9.1665C14.9998 12.3882 12.3882 14.9998 9.1665 14.9998C5.94484 14.9998 3.33317 12.3882 3.33317 9.1665Z" fill="#667185"/>
                </svg>
                <input type="text" class="input-filter !pl-[40px] w-[350px]" placeholder="Search user" name="" id="" v-model="searchQuery">
            </div>
        </div>
    </div>
    <div class="mt-[25px]">
        <!-- DataTable Component -->
        <DataTable class=" divide-y divide-gray-200 dark:divide-gray-700 rounded-[12px] border border-[#EAECF0]"
            :columns="columns"
            :data="data"
            :options="options"
            ref="tableRefs"
        >
            <thead class="!border-t-[0px]">
                <tr>
                    <th scope="col" class="ps-[24px] py-3 text-start bg-[#F0F2F5] rounded-tl-[12px] w-2/12">
                        No.
                    </th>
                    <th scope="col" class="ps-[24px] py-3 text-start bg-[#F0F2F5] rounded-tl-[12px] w-5/12">
                        Full Name
                    </th>
                    <th scope="col" class="ps-[24px] py-3 text-start bg-[#F0F2F5] rounded-tl-[12px] w-5/12">
                        Email
                    </th>
                </tr>
            </thead>
        </DataTable>
    </div>

</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import _ from 'lodash';
const props = defineProps({
    sanctum_token: {
        type: String,
        required: true,
    },
})
// Refs and reactive data
const tableRefs = ref(null);
const data = ref([]);
let dt
const searchQuery = ref('');

// DataTable columns definition
var columns = [
    {
        data: 'index',
    },
    {
        data: 'name',
    },
    {
        data: 'email',
    },
]

// DataTable options
const options = {
    // DataTable options
    pagingType: 'simple_numbers',
    order: [[ 0, "desc" ]],
    pageLength: 10,
    responsive: true,
    searchable: true,
    serverSide: true,
    html: true,
    paging: true,
    processing: true,
    serverMethod: 'post',
    // Customize language strings
    language: {
        emptyTable: "No data available in table",
        zeroRecords: "Nothing found.",
        infoEmpty: "No records available",
        info: 'Showing _START_ to _END_ of _TOTAL_ entries ',
        loadingRecords: "Loading...",
        paginate: {
            first: "First",
            last: "Last",
            next: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.4028 11.1424C14.0068 10.5007 14.0068 9.49964 13.4028 8.85789L7.27366 2.34569C6.95823 2.01055 6.43084 1.99457 6.09569 2.31C5.76055 2.62543 5.74457 3.15282 6.06 3.48797L12.1891 10.0002L6.06 16.5124C5.74457 16.8475 5.76055 17.3749 6.09569 17.6903C6.43084 18.0058 6.95824 17.9898 7.27367 17.6546L13.4028 11.1424Z" fill="#667185"/></svg>',
            previous: '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.59753 11.1424C5.99353 10.5007 5.99353 9.49964 6.59753 8.85789L12.7267 2.34569C13.0421 2.01055 13.5695 1.99457 13.9046 2.31C14.2398 2.62543 14.2558 3.15282 13.9403 3.48797L7.8112 10.0002L13.9403 16.5124C14.2558 16.8475 14.2398 17.3749 13.9046 17.6903C13.5695 18.0058 13.0421 17.9898 12.7267 17.6546L6.59753 11.1424Z" fill="#667185"/></svg>'
        },
        search: '',
        lengthMenu: '_MENU_ Entries per page',
    },
    layout: {
        topStart: '',
        topEnd: '',
        bottomStart: {
            pageLength: {
                menu: [5, 10, 25, 50]
            }
        },
        bottomEnd: 'paging',
    },
    // AJAX configuration
    ajax: {
        url: "/api/user/getUserList",
        type: 'POST',
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Authorization': `Bearer ${props.sanctum_token}`,
        },
        // Send additional data with the request eg.. search query
        "data": function(data) {
            data.search = searchQuery.value;
        },
        error: function(error) {
            console.log(error);
        }
    },
};
// On component mount, get DataTable instance
onMounted(() => {
    dt = tableRefs.value?.dt;
});

// Debounced search to reduce server calls
const reloadTable = _.debounce(() => {
    dt.ajax.reload();
}, 300);

watch(searchQuery, () => {
    reloadTable();
})
</script>
