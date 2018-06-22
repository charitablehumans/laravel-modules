<?php

namespace Modules\Carts\Http\Controllers\Api\Carts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Modules\CartDetails\Models\CartDetails;
use Modules\Carts\Http\Resources\CartResource;
use Modules\Carts\Models\Carts;

class ShoppingController extends Controller
{
    protected $type = 'shopping';

    /**
     * @SWG\Get(
     *      path="/api/cart/shopping",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'user_id': 13,
     *                  'type': 'shopping',
     *                  'total_quantity': 10,
     *                  'total_price': 100000,
     *                  'total_weight': 0,
     *                  'cart_details': [
     *                      {
     *                          'id': 1,
     *                          'post_id': 51,
     *                          'product': 'Eaque culpa tempore non neque quasi.',
     *                          'quantity': 10,
     *                          'price': 10000,
     *                          'weight': 0,
     *                          'created_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          },
     *                          'updated_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          }
     *                      },
     *                      ...
     *                  ],
     *                  'created_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"cart"},
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index()
    {
        $cart = Carts::firstOrNew(['user_id' => \Auth::user()->id, 'type' => $this->type]);
        $cart->save();

        (new CartDetails)->sync($cart->id);

        $cart->sync()->save();

        return new CartResource($cart);
    }

    /**
     * @SWG\Post(
     *      path="/api/cart/shopping",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'user_id': 13,
     *                  'type': 'shopping',
     *                  'total_quantity': 10,
     *                  'total_price': 100000,
     *                  'total_weight': 0,
     *                  'cart_details': [
     *                      {
     *                          'id': 1,
     *                          'post_id': 51,
     *                          'product': 'Eaque culpa tempore non neque quasi.',
     *                          'quantity': 10,
     *                          'price': 10000,
     *                          'weight': 0,
     *                          'created_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          },
     *                          'updated_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          }
     *                      },
     *                      ...
     *                  ],
     *                  'created_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"cart"},
     *      @SWG\Parameter(name="post_id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="quantity", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function store(\Modules\Carts\Http\Requests\Api\StoreRequest $request)
    {
        $cart = Carts::firstOrNew(['user_id' => \Auth::user()->id, 'type' => $this->type]);
        $cart->save();

        (new CartDetails)->insertUpdate($request->input(), $cart->id);
        (new CartDetails)->sync($cart->id);

        $cart->sync()->save();

        return new CartResource($cart);
    }

    /**
     * @SWG\Put(
     *      path="/api/cart/shopping",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'user_id': 13,
     *                  'type': 'shopping',
     *                  'total_quantity': 10,
     *                  'total_price': 100000,
     *                  'total_weight': 0,
     *                  'cart_details': [
     *                      {
     *                          'id': 1,
     *                          'post_id': 51,
     *                          'product': 'Eaque culpa tempore non neque quasi.',
     *                          'quantity': 10,
     *                          'price': 10000,
     *                          'weight': 0,
     *                          'created_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          },
     *                          'updated_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          }
     *                      },
     *                      ...
     *                  ],
     *                  'created_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"cart"},
     *      @SWG\Parameter(name="id", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Parameter(name="quantity", type="integer", in="formData", required=true, description="biginteger(20)"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function update(\Modules\Carts\Http\Requests\Api\UpdateRequest $request)
    {
        $cart = Carts::firstOrNew(['user_id' => \Auth::user()->id, 'type' => $this->type]);
        $cart->save();

        $cartDetail = CartDetails::where('id', $request->input('id'))->where('cart_id', $cart->id)->firstOrFail();
        $cartDetail->fill($request->input())->save();
        (new CartDetails)->sync($cart->id);

        $cart->sync()->save();

        return new CartResource($cart);
    }

    /**
     * @SWG\Delete(
     *      path="/api/cart/shopping",
     *      summary="",
     *      description="
     *          {
     *              'data': {
     *                  'user_id': 13,
     *                  'type': 'shopping',
     *                  'total_quantity': 10,
     *                  'total_price': 100000,
     *                  'total_weight': 0,
     *                  'cart_details': [
     *                      {
     *                          'id': 1,
     *                          'post_id': 51,
     *                          'product': 'Eaque culpa tempore non neque quasi.',
     *                          'quantity': 10,
     *                          'price': 10000,
     *                          'weight': 0,
     *                          'created_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          },
     *                          'updated_at': {
     *                              'date': '2018-03-22 17:49:29.000000',
     *                              'timezone_type': 3,
     *                              'timezone': 'UTC'
     *                          }
     *                      },
     *                      ...
     *                  ],
     *                  'created_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  },
     *                  'updated_at': {
     *                      'date': '2018-03-22 17:49:29.000000',
     *                      'timezone_type': 3,
     *                      'timezone': 'UTC'
     *                  }
     *              }
     *          }
     *      ",
     *      produces={"application/json"},
     *      tags={"cart"},
     *      @SWG\Parameter(name="item_hash", type="string", in="formData", required=true, description="varchar"),
     *      @SWG\Response(response=200, description="OK"),
     *      @SWG\Response(response=401, description="Unauthorized"),
     *      @SWG\Response(response=422, description="Unprocessable Entity"),
     * )
     */
    public function destroy(\Modules\Carts\Http\Requests\Api\DestroyRequest $request)
    {
        $cartDetail = CartDetails::findOrFail($request->input('id'));
        $cartId = $cartDetail->cart_id;
        $cartDetail->delete();

        (new CartDetails)->sync($cartId);

        $cart = Carts::findOrFail($cartId)->sync();
        $cart->save();

        return new CartResource($cart);
    }
}
