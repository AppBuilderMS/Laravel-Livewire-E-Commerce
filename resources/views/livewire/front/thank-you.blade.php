@push('styles')
    <style>
        .thankyou{
            min-height: 84vh;

        }
    </style>
@endpush
<div>
    <!-- Header -->
    <header class="header text-white pb-6 bg-gradient-slate" style="padding-top: 2.5rem">
    </header><!-- /.header -->

    <main class="main-content text-center pb-lg-8 d-flex  align-items-center thankyou">
        <div class="container ">
            <div class="row ">
                <div class="col-md-12">
                    <h1>Thank you for your order</h1>
                    <h5>A confirmation email was sent</h5>
                    <a href="{{route('shop.index')}}" class="mt-6 btn btn-outline-success">Continue Shopping</a>
                </div>
            </div>
        </div>
    </main>
</div>
