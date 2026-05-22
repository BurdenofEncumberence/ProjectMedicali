<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: #085041;">
            Checkout
        </h2>
    </x-slot>

    <style>
        body, .bg-gray-100 { background-color: #f0faf6 !important; }

        .med-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #c9e9de;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(15, 110, 86, 0.06);
        }

        .med-card-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #085041;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 14px;
        }

        .med-select, .med-input {
            border: 1px solid #9FE1CB;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 0.875rem;
            color: #085041;
            background-color: #f4faf8;
            width: 100%;
            outline: none;
            transition: border-color 0.15s;
        }

        .med-select:focus, .med-input:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.15);
        }

        .med-select option { color: #085041; }

        .btn-add {
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: background-color 0.15s;
        }

        .btn-add:hover { background-color: #0F6E56; }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #E1F5EE;
        }

        .cart-item:last-of-type { border-bottom: none; }

        .cart-item-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #085041;
        }

        .cart-item-price {
            font-size: 0.75rem;
            color: #1D9E75;
            margin-top: 2px;
        }

        .qty-btn {
            background-color: #E1F5EE;
            color: #085041;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.15s;
        }

        .qty-btn:hover { background-color: #9FE1CB; }

        .qty-display {
            font-size: 0.875rem;
            font-weight: 600;
            color: #085041;
            width: 24px;
            text-align: center;
        }

        .item-subtotal {
            font-size: 0.875rem;
            font-weight: 600;
            color: #085041;
            min-width: 80px;
            text-align: right;
        }

        .btn-remove {
            background: none;
            border: none;
            color: #A32D2D;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            margin-left: 8px;
            padding: 2px 6px;
            border-radius: 4px;
            transition: background-color 0.15s;
        }

        .btn-remove:hover { background-color: #FCEBEB; }

        .empty-cart {
            font-size: 0.875rem;
            color: #9FE1CB;
            text-align: center;
            padding: 28px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #3B6D11;
            padding: 5px 0;
        }

        .summary-discount {
            color: #A32D2D;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 1rem;
            font-weight: 700;
            color: #085041;
            padding-top: 12px;
            margin-top: 6px;
            border-top: 2px solid #E1F5EE;
        }

        .btn-checkout {
            width: 100%;
            background-color: #1D9E75;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 13px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 16px;
            transition: background-color 0.15s;
        }

        .btn-checkout:hover { background-color: #085041; }

        .discount-badge {
            display: inline-block;
            margin-top: 8px;
            background: #E1F5EE;
            color: #0F6E56;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-6 sm:px-8"
         x-data="checkout()">

        @if(session('error'))
            <div style="background: #FCEBEB; color: #791F1F; border: 1px solid #F09595; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.875rem;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Left: Medicine Selector --}}
                <div class="lg:col-span-2 space-y-4">

                    {{-- Search & Add Medicine --}}
                    <div class="med-card">
                        <div class="med-card-title">Add Medicine</div>

                        <div class="flex gap-3 items-center">
                            <select x-model="selectedMedicine"
                                    class="med-select flex-1">
                                <option value="">-- Select Medicine --</option>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}"
                                            data-name="{{ $medicine->name }}"
                                            data-price="{{ $medicine->price }}"
                                            data-stock="{{ $medicine->stock_qty }}">
                                        {{ $medicine->name }} — ₱{{ number_format($medicine->price, 2) }} ({{ $medicine->stock_qty }} in stock)
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" x-model="selectedQty"
                                   min="1" placeholder="Qty"
                                   class="med-input"
                                   style="width: 80px;">

                            <button type="button"
                                    @click="addItem()"
                                    class="btn-add">
                                Add
                            </button>
                        </div>
                    </div>

                    {{-- Cart Items --}}
                    <div class="med-card">
                        <div class="med-card-title">Cart</div>

                        <template x-if="cart.length === 0">
                            <p class="empty-cart">No items added yet.</p>
                        </template>

                        <template x-for="(item, index) in cart" :key="index">
                            <div class="cart-item">
                                <div>
                                    <p class="cart-item-name" x-text="item.name"></p>
                                    <p class="cart-item-price">₱<span x-text="item.price.toFixed(2)"></span> each</p>
                                    <input type="hidden" :name="'medicines[' + index + '][id]'" :value="item.id">
                                    <input type="hidden" :name="'medicines[' + index + '][qty]'" :value="item.qty">
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-2">
                                        <button type="button"
                                                @click="decreaseQty(index)"
                                                class="qty-btn">−</button>
                                        <span class="qty-display" x-text="item.qty"></span>
                                        <button type="button"
                                                @click="increaseQty(index)"
                                                class="qty-btn">+</button>
                                    </div>
                                    <span class="item-subtotal">
                                        ₱<span x-text="(item.price * item.qty).toFixed(2)"></span>
                                    </span>
                                    <button type="button"
                                            @click="removeItem(index)"
                                            class="btn-remove">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Right: Summary --}}
                <div class="space-y-4">

                    {{-- Discount --}}
                    <div class="med-card">
                        <div class="med-card-title">Discount</div>
                        <select name="discount_type"
                                x-model="discountType"
                                class="med-select">
                            <option value="none">No Discount</option>
                            <option value="senior">Senior Citizen (20%)</option>
                            <option value="pwd">PWD (20%)</option>
                        </select>
                        <template x-if="discountType !== 'none'">
                            <span class="discount-badge">20% discount applied</span>
                        </template>
                    </div>

                    {{-- Payment Method --}}
                    <div class="med-card">
                        <div class="med-card-title">Payment Method</div>
                        <select name="payment_method"
                                class="med-select">
                            <option value="cash">Cash</option>
                            <option value="card">Credit / Debit Card</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                        </select>
                    </div>

                    {{-- Order Summary --}}
                    <div class="med-card">
                        <div class="med-card-title">Order Summary</div>

                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>₱<span x-text="subtotal().toFixed(2)"></span></span>
                        </div>

                        <div class="summary-row summary-discount">
                            <span>Discount</span>
                            <span>− ₱<span x-text="discountAmount().toFixed(2)"></span></span>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span>₱<span x-text="total().toFixed(2)"></span></span>
                        </div>

                        <button type="submit" class="btn-checkout">
                            Complete Sale
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script>
        function checkout() {
            return {
                cart: [],
                selectedMedicine: '',
                selectedQty: 1,
                discountType: 'none',

                addItem() {
                    if (!this.selectedMedicine) return;

                    const select = document.querySelector('select[x-model="selectedMedicine"]');
                    const option = select.options[select.selectedIndex];
                    const id = this.selectedMedicine;
                    const name = option.getAttribute('data-name');
                    const price = parseFloat(option.getAttribute('data-price'));
                    const stock = parseInt(option.getAttribute('data-stock'));
                    const qty = parseInt(this.selectedQty) || 1;

                    if (qty > stock) {
                        alert('Quantity exceeds available stock (' + stock + ' left)');
                        return;
                    }

                    const existing = this.cart.find(i => i.id === id);
                    if (existing) {
                        existing.qty += qty;
                    } else {
                        this.cart.push({ id, name, price, qty, stock });
                    }

                    this.selectedMedicine = '';
                    this.selectedQty = 1;
                },

                increaseQty(index) {
                    const item = this.cart[index];
                    if (item.qty < item.stock) item.qty++;
                },

                decreaseQty(index) {
                    if (this.cart[index].qty > 1) {
                        this.cart[index].qty--;
                    }
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                },

                subtotal() {
                    return this.cart.reduce((sum, item) => sum + item.price * item.qty, 0);
                },

                discountAmount() {
                    if (this.discountType === 'none') return 0;
                    return this.subtotal() * 0.20;
                },

                total() {
                    return this.subtotal() - this.discountAmount();
                }
            }
        }
    </script>
</x-app-layout>