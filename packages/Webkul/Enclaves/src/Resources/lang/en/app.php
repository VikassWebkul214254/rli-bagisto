<?php

return [
    'emails' => [
        'dear'   => 'Dear :customer_name',
        'thanks' => 'If you need any kind of help please contact us at <a href=":link" style=":style">:email</a>.<br/>Thanks!',

        'customers' => [
            'registration' => [
                'credentials-description' => 'Your account has been created. Your account details are below:',
                'description'             => 'Your account has now been created successfully and you can login using your email address and password credentials. Upon logging in, you will be able to access other services including reviewing past orders, wishlists and editing your account information.',
                'greeting'                => 'Welcome and thank you for registering with us!',
                'password'                => 'Password',
                'sign-in'                 => 'Sign in',
                'subject'                 => 'New Customer Registration',
                'update'                  => 'Customer Detail Update',
                'username-email'          => 'Username/Email',
            ],

            'forgot-password' => [
                'description'    => 'You are receiving this email because we received a password reset request for your account.',
                'greeting'       => 'Forgot Password!',
                'reset-password' => 'Reset Password',
                'subject'        => 'Reset Password Email',
            ],

            'update-password' => [
                'description' => 'You are receiving this email because you have updated your password.',
                'greeting'    => 'Password Updated!',
                'subject'     => 'Password Updated',
            ],

            'verification' => [
                'description'  => 'Please click the button below to verify your email address.',
                'greeting'     => 'Welcome!',
                'subject'      => 'Account Verification Email',
                'verify-email' => 'Verify Email Address',
            ],

            'commented' => [
                'description' => 'Note Is - :note',
                'subject'     => 'New comment Added',
            ],

            'subscribed' => [
                'description' => 'Congratulations and welcome to our newsletter community! We\'re excited to have you on board and keep you updated with the latest news, trends, and exclusive offers.',
                'greeting'    => 'Welcome to our newsletter!',
                'subject'     => 'You! Subscribe to Our Newsletter',
                'unsubscribe' => 'Unsubscribe',
            ],
        ],

        'orders' => [
            'created' => [
                'greeting' => 'Thanks for your Order :order_id placed on :created_at',
                'subject'  => 'New Order Confirmation',
                'summary'  => 'Summary of Order',
                'title'    => 'Order Confirmation!',
            ],

            'invoiced' => [
                'greeting' => 'Your invoice #:invoice_id for Order :order_id created on :created_at',
                'subject'  => 'New Invoice Confirmation',
                'summary'  => 'Summary of Invoice',
                'title'    => 'Invoice Confirmation!',
            ],

            'shipped' => [
                'greeting' => 'Your order :order_id placed on :created_at has been shipped',
                'subject'  => 'New Shipment Confirmation',
                'summary'  => 'Summary of Shipment',
                'title'    => 'Order Shipped!',
            ],

            'refunded' => [
                'greeting' => 'Refund has been initiated for the :order_id placed on :created_at',
                'subject'  => 'New Refund Confirmation',
                'summary'  => 'Summary of Refund',
                'title'    => 'Order Refunded!',
            ],

            'canceled' => [
                'greeting' => 'Your Order :order_id placed on :created_at has been canceled',
                'subject'  => 'New Order Canceled',
                'summary'  => 'Summary of Order',
                'title'    => 'Order Canceled!',
            ],

            'commented' => [
                'subject' => 'New comment Added',
                'title'   => 'New comment added to your order :order_id placed on :created_at',
            ],

            'billing-address'   => 'Billing Address',
            'carrier'           => 'Carrier',
            'contact'           => 'Contact',
            'discount'          => 'Discount',
            'grand-total'       => 'Grand Total',
            'name'              => 'Name',
            'payment'           => 'Payment',
            'price'             => 'Price',
            'qty'               => 'Qty',
            'shipping'          => 'Shipping',
            'shipping-address'  => 'Shipping Address',
            'shipping-handling' => 'Shipping Handling',
            'sku'               => 'SKU',
            'subtotal'          => 'Subtotal',
            'tax'               => 'Tax',
            'tracking-number'   => 'Tracking Number : :tracking_number',
        ],
    ],

    'shop' => [
        'layouts' => [
            'my-account'   => 'My Account',
            'dashboard'    => "Dashboard",
            'profile'      => 'Profile',
            'documents'    => 'Documents',
            'inquiries'    => 'Inquiries',
            'transactions' => 'Transactions',
            'inquiries'    => 'Inquiries',
            'help-seminar' => 'Help Seminar',
        ],

        'customers' => [
            'login-form' => [
                'page-title' => 'Log in your Account',
            ],

            'account' => [
                'customer-profile' => [
                    'personal-details' => [
                        'title'           => 'Personal Details',
                        'full-name'       => 'Full Name',
                        'dob'             => 'Date of Birth',
                        'email'           => 'Email',
                        'phone'           => 'Phone',
                        'lot_unit_number' => 'Lot / Unit number: ',
                        'select'          => "Select",
                    ],

                    'view' => [
                        'title'           => 'Personal Details',

                        'info' => [
                            'full-name'       => 'Full Name', 
                            'dob'             => 'Date of Birth',
                            'email'           => 'Email',
                            'phone'           => 'Phone',
                            'lot-unit-number' => 'Lot / Unit number: ',
                            'civil-status'    => "Civil Status",
                            'gender'          => 'Gender',
                            'address-1'       => 'Address-1',
                        ],

                        'information' => [
                            'title'                     => 'Employment Information',
                            'full-name'                 => 'Full Name',
                            'dob'                       => 'Date of Birth',
                            'email'                     => 'Email',
                            'phone'                     => 'Phone',
                            'lot-unit-number'           => 'Lot / Unit number: ',
                            'select'                    => "Select",
                            'civil-status'              => "Civil Status",
                            'gender'                    => "Gender",
                            'address-1'                 => 'Address 1',
                            'address-2'                 => 'Address 2',
                            'work-industry'             => 'Work Industry:',
                            'gross-income'              => 'Gross Income: ',
                            'nationality'               => 'Nationality',
                            'current-position'          => 'Current Position',
                            'tax-identification-number' => 'Tax Identification Number:',
                            'PAG-IBIG-number'           => 'PAG-IBIG Number',
                            'SSS-GSIS-number'           => 'SSS Number',

                            'employment' => [
                                'type'   => "Employment Type",
                                'status' => 'Employment Status',
                            ],

                            'employer' => [
                                'name'    => 'Employer Name',
                                'number'  => 'Employer Contact Number:',
                                'address' => 'Employer Address',
                            ],
                        ],

                        'co-borrower' => [
                            'title'                     => "Borrower's Data (Spouse, Attorney in fact, Co-Borrower)",
                            'secondary-address'         => 'Secondary Home Address: ',
                            'civil-status'              => 'Civil Status: ',
                            'gender'                    => 'Gender',
                            'dob'                       => 'Date of Birth',
                            'primary-email-address'     => 'Primary Email Address:',
                            'primary-phone-number'      => 'Primary Phone Number',
                            'work-industry'             => 'Work Industry',
                            'gross-income'              => 'Gross Income: ',
                            'nationality'               => 'Nationality',
                            'current-position'          => 'Current Position: ',
                            'tax-identification-number' => 'Tax Identification Number:',
                            'PAG-IBIG-number'           => 'PAG-IBIG Number',
                            'SSS-GSIS-number'           => 'SSS Number',

                            'employment' => [
                                'type'   => "Employment Type",
                                'status' => 'Employment Status',
                            ],

                            'employer' => [
                                'name'    => 'Employer Name',
                                'number'  => 'Employer Contact Number: ',
                                'address' => 'Employer Address: ',
                            ],
                        ],
                    ],

                    'header' => [
                        'email' => 'Email: ',
                        'age'   => 'Age: ',
                        'step'  => 'Steps to get your dream house',
                        'read-now' => 'Read Now',
                    ],

                    'form' => [
                        'full-name'              => 'Full Name: ',
                        'address'                => 'Primary Home Address: ',
                        'lot-unit-number'        => 'Lot / Unit Number: ',
                        'select'                 => 'Select',
                        'employment-information' => 'Employment Information',
                        'co-Borrower'            => "Borrower's Data (Spouse, Attorney in fact, Co-Borrower)",
                    ],
                ],

                'dashboard' => [
                    'index' => [
                        'title' => 'Dashboard',
                    ],

                    'header' => [
                        'monthly-amortization' => 'Monthly Amortization: ',
                        'reserved' => 'Reserved',
                        'total-contract-price' => 'Total Contract Price',
                    ],

                    'body' => [
                        'payment-details' => 'Payment Details',
                        'tcp'             => 'TCP',
                        'down-payment'    => 'Down Payment',
                        'balance'         => 'Balance',
                        'info'            => '*remaining balance will be paid thru Pag-Ibig Financing',
                    ],
                ],

                'transactions' => [
                    'index' => [
                        'title' => 'Transactions',
                    ],

                    'view' => [
                        'page-title' => 'Order #:order_id',
                        'details'    => 'Transaction Details',
                    ],

                    'datagrid' => [
                        'transaction-no' => 'Transaction No',
                        'property'       => 'Property',
                        'sku'            => 'SKU',
                        'contract'       => 'Contract',
                        'reservation'    => 'Reservation Fee',
                        'status'         => [
                            'title' => 'Status',
                            'options' => [
                                'processing'      => 'Processing',
                                'completed'       => 'Completed',
                                'canceled'        => 'Canceled',
                                'closed'          => 'Closed',
                                'pending'         => 'Pending',
                                'pending-payment' => 'Pending Payment',
                                'fraud'           => 'Fraud',
                            ],
                        ],
                    ],
                ],

                'inquiries' => [
                    'title'         => 'Inquiries',
                    'help_test'     => 'How can we help you?',
                    'submit-header' => 'Submit Ticket',
                    'submit-text'   => 'Click here to report your concern and we will respond as soon as we can.',
                    'tickets'       => 'Your Tickets',
                    'tickets_text'  => 'You can follow-up and get updates on your active tickets here.',
                    'frequently'    => 'Frequently Asked Questions',
                    'placeholder'   => 'Write the details of your concern here....',
                    'reservation'   => 'Reservation',
                    'btn-upload'    => 'Upload Files',
                    'submit'        => 'Submit',
                    'load-more'     => 'Load More',
                    'concern'       => 'Nature of concern: ',
                    'list' => [
                        'title'          => 'Your Tickets',
                        'create-success' => 'Ticket successfully created',
                    ],

                    'success'      => 'Successfully submitted!',
                    'upload-files' => 'Upload Files',
                ],

                'documents' => [
                    'title' => 'Documents',
                    'go-to-documents' => 'Go to my Documents',
                    'press-button'    => 'Press the button above and enter your',
                    'reference-code'  => 'Reference Code: ',
                    'reference-info'  => 'to confirm and manage your documents.',
                ],

                'help-seminar' => [
                    'title' => 'Help Seminar',
                ],
            ],

            'choose-unit'          => 'Choose Unit',
            'browse-properties'    => 'Browse Properties',
            'total-contract-price' => 'Total Contract Price',
        ],

        'product' => [
            'reserve-now'     => 'Reserve Now',
            'select-area'     => 'Check & Select Area',
            'reservation-fee' => 'Reservation Fee: ',
            'contract-price'  => 'Total Contract Price:',
            'first-floor'     => '1st Floor',
            'floor-area'      => 'Floor Area',
            'location'        => 'Location: ',
            'bedrooms'        => 'Bedrooms',
            't_and_b'         => 'Toilet and Bath:',
            'unit'            => 'Unit',
            'cart'            => [
                'add-to-cart' => 'Choose Unit',
            ],
        ],

        'authentication' => [
            'title'        => 'Verify your profile',
            'body_text'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
            'authenticate' => 'Proceed to Booking',
        ],

        'homepage' => [
            'slider' => [
                'title' => 'Raemulan Lands Inc.',
            ],

            'most-view' => [
                'title'          => 'Our Newest Communities',
                'contract-price' => 'Total Contract Price',
                'choose-unit'    => 'Choose Unit',
            ],
        ],

        'components' => [
            'layouts' => [
                'read-more' => 'Read More',
                'read-less' => 'Read Less',
                'header' => [
                    'login'           => 'Log in',
                    'manage-property' => 'Manage your property.',
                ],
            ],
        ],
    ],

    'admin' => [
        'settings' => [
            'themes' => [
                'edit' => [
                    'button_text'       => 'Button Text',
                    'slider_syntax'     => 'Slider Syntax',
                    'required'          => 'Field is Required.',
                    'limit_slider_text' => '30 Letters allow only',
                    'limit_button_text' => '20 Letters allow only',
                    'edit-slider'       => 'Edit theme slider',
                    'image_cdn_link'    => 'CDN Link',
                    'cdn_status'        => 'CDN Link Status',
                ],
            ],
        ],

        'menu' => [
            'inquiries' => 'Inquiries',
            'tickets'   => 'Tickets',
            'faq'       => 'Frequently Asked Questions',
        ],

        'inquiries' => [
            'title' => 'Inquiries',

            'tickets' => [
                'title' => 'Tickets',

                'datagrid' => [
                    'header' => [
                        'id'            => 'id',
                        'customer-name' => 'Customer Name',
                        'reason'        => 'Reason',
                        'comment'       => 'Comments',
                        'status'        => 'Status',
                        'created-at'    => 'Created At',
                    ],
                ],

                'form' => [
                    'create' => [
                        'customer'       => 'Customer',
                        'create-btn'     => 'Create',
                        'reason'         => 'Reason',
                        'status'         => 'Status',
                        'comment'        => 'Comment',
                        'save-btn'       => 'Save',
                        'create-success' => 'Inquiry created successfully',
                    ],

                    'view' => [
                        'comment'         => 'Comment:',
                        'attachment'      => 'Attachment:',
                        'comment-name'    => 'Comment Name:',
                        'no-image'        => 'No image Available',
                        'attachment-info' => 'Click on Image for Download',
                        'delete-btn'      => 'Delete',
                    ],

                    'edit' => [
                        'edit-btn'       => 'Edit',
                        'customer'       => 'Customer',
                        'reason'         => 'Reason',
                        'status'         => 'Status',
                        'comment'        => 'Comment',
                        'update-btn'     => 'Update',
                        'delete'         => 'Delete',
                        'error'          => 'Some think is wrong',
                        'delete-success' => 'Inquiry Deleted Successfully',
                        'update-success' => 'Inquiry updated successfully',
                    ],
                ],
            ],

            'faq' => [
                'title' => 'Frequently Asked Questions',

                'datagrid' => [
                    'id'         => 'id',
                    'full_name'  => 'Customer Name',
                    'question'   => 'Question',
                    'answer'     => 'Answer',
                    'status'     => 'Status',
                    'created_at' => 'Created At',
                    'get'        => 'Edit',
                ],

                'form' => [
                    'create' => [
                        'customer'          => 'Customer',
                        'question'          => 'Question',
                        'answer'            => 'Answer',
                        'selected-customer' => 'Selected Customer',
                        'create-btn'        => 'Create',
                        'status'            => 'Status',
                        'save-btn'          => 'Save',
                        'create-success'    => 'Successfully created',
                        'delete-success'    => 'Successfully Deleted',
                        'delete-failed'     => 'FAQ deleted Failed',
                        'update-success'    => 'Successfully Updated',
                        'update-failed'     => 'Updated Failed',
                    ],

                    'view' => [
                        'comment'         => 'Comment:',
                        'attachment'      => 'Attachment:',
                        'comment-name'    => 'Comment Name:',
                        'no-image'        => 'No image Available',
                        'attachment-info' => 'Click on Image for Download',
                        'delete-btn'      => 'Delete',
                    ],

                    'edit' => [
                        'edit-btn'          => 'Edit',
                        'selected-customer' => 'Selected Customer',
                        'customer'          => 'Customer',
                        'reason'            => 'Reason',
                        'status'            => 'Status',
                        'comment'           => 'Comment',
                        'question'          => 'Question',
                        'answer'            => 'Answer',
                        'update-btn'        => 'Update',
                        'delete'            => 'Delete',
                        'error'             => 'Some think is wrong',
                        'delete-success'    => 'Inquiry Deleted Successfully',
                        'update-success'    => 'Inquiry updated successfully',
                    ],
                ],
            ],
        ],

        'catalog' => [
            'category' => [
                'index' => [
                    'button-setting' => 'Our Newest Communities Button Setting',
                    'button' => [
                        'text'             => 'Text',
                        'color'            => 'Color',
                        'border-color'     => 'Border Color',
                        'background-color' => 'Background Color',
                        'sort'             => 'Sort',
                        'banner'           => 'Community Banner',
                        'banner-info'      => 'Community Banner aspect ration (1320px X 300px)',
                        'field-info'       => "Please ensure that the value starts with a '#' symbol, like this: #ABCD",
                    ],
                ],
            ],
        ],
    ],
];
