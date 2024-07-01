<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GriyaBambu || DASHBOARD</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .relative {
            position: relative;
        }

        .inline-flex {
            display: inline-flex;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .text-sm {
            font-size: 0.875rem;
        }

        .font-medium {
            font-weight: 500;
        }

        .text-gray-500 {
            color: #6c757d;
        }

        .text-gray-700 {
            color: #495057;
        }

        .bg-white {
            background-color: #fff;
        }

        .border {
            border: 1px solid #dee2e6;
        }

        .border-gray-300 {
            border-color: #dee2e6;
        }

        .cursor-default {
            cursor: default;
        }

        .leading-5 {
            line-height: 1.25;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .hover\:text-gray-500:hover {
            color: #6c757d;
        }

        .focus\:outline-none:focus {
            outline: none;
        }

        .focus\:ring:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .transition {
            transition: all 0.15s ease-in-out;
        }

        .ease-in-out {
            transition-timing-function: ease-in-out;
        }

        .duration-150 {
            transition-duration: 150ms;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .rounded-l-md {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .rounded-r-md {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }

        .z-0 {
            z-index: 0;
        }

        .z-10 {
            z-index: 10;
        }

        .ml-3 {
            margin-left: 0.75rem;
        }

        .-ml-px {
            margin-left: -1px;
        }

        .text-gray-400 {
            color: #ced4da;
        }

        .active\:bg-gray-100:active {
            background-color: #f8f9fa;
        }

        .active\:text-gray-500:active {
            color: #6c757d;
        }

        .focus\:border-blue-300:focus {
            border-color: #66afe9;
        }

        .active\:text-gray-700:active {
            color: #495057;
        }

        .active\:bg-gray-100:active {
            background-color: #f8f9fa;
        }

        .sm\:hidden {
            display: none !important;
        }

        .sm\:flex {
            display: flex !important;
        }

        .sm\:items-center {
            align-items: center !important;
        }

        .sm\:justify-between {
            justify-content: space-between !important;
        }

        .text-gray-700 {
            color: #495057;
        }

        .text-gray-500 {
            color: #6c757d;
        }

        .hover\:text-gray-500:hover {
            color: #6c757d;
        }

        .hover\:text-gray-400:hover {
            color: #ced4da;
        }

        .active\:text-gray-700:active {
            color: #495057;
        }

        .w-5 {
            width: 1.25rem;
        }

        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }
    </style>
    @stack('styles')

</head>
