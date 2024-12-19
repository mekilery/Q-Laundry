namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class OrderController extends Controller
{
public function viewOrders($customerId)
{
$customer = Customer::findOrFail($customerId);
$orders = $customer->orders()->whereNull('deleted_at')->get(); // Exclude soft-deleted orders

return view('admin.customers.view-orders', compact('customer', 'orders'));
}
}
