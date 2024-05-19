
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>Header</h3>
                <p>tes</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">
                <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4>Proforma Invoice Belum Di-Release</h4>
            <div class="card-header-action">
                <a href="{{ route('release_order.index') }}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive table-invoice">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No. PFI</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($performanceInvoices as $invoice)
                            @if ($invoice->release_order != '1')
                                <tr>
                                    <td>{{ $invoice->no_pfi }}</td>
                                    <td>{{ $invoice->customer->nama }}</td>
                                    <td>
                                        @php
                                            $jumlah_produk = $invoice->details()->count();
                                            $jumlah_item = $invoice->details()->sum('qty');
                                            $produk_text = $jumlah_produk > 0 ? $jumlah_produk . ' Products' : 'No Product';
                                            $item_text = $jumlah_item > 0 ? $jumlah_item . ' Items' : 'No Item';
                                        @endphp
                                        {{ $produk_text }}, {{ $item_text }}
                                    </td>
                                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4>Purchase Order Belum Di-Terima</h4>
            <div class="card-header-action">
                <a href="{{ route('po_receipt.index') }}" class="btn btn-danger">View More <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive table-invoice">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No. PO</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrders as $order)
                            @php
                                $isReceived = $order->poReceipt()->exists();
                            @endphp
                            @if (!$isReceived)
                                <tr>
                                    <td>{{ $order->no_po }}</td>
                                    <td>{{ $order->tanggal }}</td>
                                    <td>{{ $order->supplier->nama }}</td>
                                    <td>
                                        @php
                                            $jumlah_produk = $order->purchaseDetails()->count();
                                            $jumlah_item = $order->purchaseDetails()->sum('qty');
                                            $produk_text = $jumlah_produk > 0 ? $jumlah_produk . ' Products' : 'No Product';
                                            $item_text = $jumlah_item > 0 ? $jumlah_item . ' Items' : 'No Item';
                                        @endphp
                                        {{ $produk_text }}, {{ $item_text }}
                                    </td>
                                    <td>
                                        @php
                                            $total_amount = 0;
                                            foreach ($order->purchaseDetails as $detail) {
                                                $total_amount += $detail->qty * $detail->harga;
                                            }
                                        @endphp
                                        {{ number_format($total_amount, 2) }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="col-12 col-md-12 col-lg-12">
    <div class="card card-secondary">
        <div class="card-header">
            <h4>Persediaan Barang</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="produk-inventory-table" class="table table-bordered" style="margin-top: 1rem;">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="15%">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th width="10%">Qty</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
