@extends('admin.layout.master')

@section('content')
<div class="content-wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (session('message'))
                        <div class="alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Product</h3>

                  <div class="d-flex justify-content-end">
                    <a class="btn btn-primary"href="{{ route('admin.product.create') }}">Create</a>
                </div>
                </div>
                <div>
                    <form method="GET">
                        <input type="text" placeholder="Search..." name="keyword" value="{{ is_null(request()->keyword) ? '' : request()->keyword }}">
                        <button type="submit">Search</button>
                    </form>
                  </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Product Category Name</th>
                        <th style="width: 40px">Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->slug }}</td>
                                <td>{{ number_format($product->price, 2) }}</td>
                                <td>{!! $product->description !!}</td>
                                <td>
                                    @php
                                        $imageLink = (is_null($product->image_url) || !file_exists("images/" . $product->image_url)) ? 'default-product-image.png' : $product->image_url;
                                    @endphp
                                    <img src="{{ asset('images/'.$imageLink) }}" alt="{{ $product->name }}" width="150" height="150">
                                </td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    <a class="btn btn-{{ $product->status ? 'success' : 'danger' }}">
                                        {{ $product->status ? 'Show' : 'Hide' }}
                                    </a>
                                </td>
                                <td>
                                    <form method="post" action="{{ route('admin.product.destroy', ['product' => $product->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <a href="{{ route('admin.product.show', ['product' => $product->id]) }}" class="btn btn-primary">Edit</a>
                                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No Product</td>
                            </tr>
                        @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $products->appends(request()->query())->links() }}
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
</div>
@endsection
