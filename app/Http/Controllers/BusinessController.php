<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Currency;
use App\Business;
use App\BusinessLocation;

class BusinessController extends Controller
{
    //
    public function index(Request $request)
    {
        $currencies = Currency::get();
        $business = Business::first();
        $title = "Business Profile";
        return view('business.profile', compact('title', 'currencies', 'business'));
    }

    public function updateBusiness(Request $request)
    {
        // dump($request->file('logo')->getSize());

        $business = Business::find($request->id);
        $business->name = $request->name;
        $business->desc_name = $request->desc_name ?? NULL;
        // $business->currency_id = $request->currency_id;
        // $business->start_date = $request->start_date;

        // if ( isset($request->check_tax) ){
        //     if ( $request->tax_type == 'percentage' ){
        //         $business->tax = $request->tax . "%";
        //     }else {
        //         $business->tax = $request->tax;
        //     }
        // }else {
        //     $business->tax = '';
        // }

        // if ( isset($request->check_discount) ){
        //     $business->discount_name = $request->discount_name;
        //     if ( $request->discount_type == 'percentage' ){
        //         $business->discount_value = $request->discount . "%";
        //     }else {
        //         $business->discount_value = $request->discount;
        //     }
        // }else {
        //     $business->discount_name = '';
        //     $business->discount_value = '';
        // }


        if ( $request->hasFile('icon') ){  
            $extensions = array('png', 'ico');
            $max_size = 3000000; // Bytes / 3 MB
            $file_name = 'icon-' . str_replace(' ', '-', strtolower($request->name)) . '.' . $request->file('icon')->extension();
            
            if ( $max_size < $request->file('icon')->getSize() ){
                toastr()->error('Opss!... File size is too large. (Max Size 3MB)');
                return redirect()->back();
            }
            
            if ( !in_array($request->file('icon')->extension(), $extensions)  ){
                toastr()->error('Opss!... your file is not supported for icon. (Use .ico / .png)');
                return redirect()->back();
            }

            $request->file('icon')->move('uploads', $file_name);
            $business->icon = $file_name;
        }

        if ( $request->hasFile('logo') ){  
            $extensions = array('png', 'ico');
            $max_size = 3000000; // Bytes / 3 MB
            $file_name = 'logo-' . str_replace(' ', '-', strtolower($request->name)) . '.' . $request->file('logo')->extension();
            
            if ( $max_size < $request->file('logo')->getSize() ){
                toastr()->error('Opss!... File size is too large. (Max Size 3MB)');
                return redirect()->back();
            }
            
            if ( !in_array($request->file('logo')->extension(), $extensions)  ){
                toastr()->error('Opss!... your file is not supported for logo. (Use .ico / .png)');
                return redirect()->back();
            }

            $request->file('logo')->move('uploads', $file_name);
            $business->logo = $file_name;
        }

        if ( $business->save() ){
            toastr()->success('Business Setting has been updated now.');
            return redirect()->back();
        }else {
            toastr()->error('Opss!... Something Wrong.');
            return redirect()->back();
        }

    }

    public function locations()
    {
        if ( request()->ajax() ){
            $data = Business::first()->locations;
            return datatables()->of($data)
                ->addColumn('full_address', function($data){
                    $html = $data->address . ', ' . $data->city . ', ' . $data->state . ', ' . $data->zip_code;
                    return $html;
                })
                ->addColumn('actions', function($data){
                    if ( (Gate::allows('business.update_location') || Gate::allows('business.delete_location')) ){

                        $html = "";
                        if ( Gate::allows('business.update_location') ){
                            $btnUpdate = '<a href="' . route('business.edit_location', ['id' => $data->id]) . '"><button type="button" class="btn btn-warning btn-round btn-sm m-1"><i class="ti-pencil-alt"></i>' . __('Edit') . '</button></a>';
                        }

                        if ( Gate::allows('business.delete_location') ){
                            if ( isset($btnUpdate) ){
                                if ( isset($btnPermission) ){
                                    $html = '<form action="' . route('business.delete_location', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" type="submit" data-name="Location"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                }else {
                                    $html = '<form action="' . route('business.delete_location', ['id' => $data->id]) . '" method="POST">' . csrf_field() . $btnUpdate .'
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" type="submit" data-name="Location"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                }
                            }else {
                                if ( isset($btnPermission) ){
                                    $html = '<form action="' . route('business.delete_location', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" type="submit" data-name="Location"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                }else{
                                    $html = '<form action="' . route('business.delete_location', ['id' => $data->id]) . '" method="POST">' . csrf_field() . '
                                    <button class="btn btn-danger btn-round btn-sm m-1 destroy" type="submit" data-name="Location"><i class="ti-trash"></i>' . __('Delete') . '</button>
                                </form>';
                                }
                            }
                        }else {
                            if ( isset($btnUpdate) ){
                                $html .= $btnUpdate;
                            }
                        }
                    }else {
                        $html = '';
                    }
                        return $html;
                    })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        $title = 'Business Locations';
        return view('business.locations', compact('title'));
    }

    public function createLocation()
    {
        $business = Business::get();
        $title = "Create Location";
        return view('business.create-location', compact('title', 'business'));
    }

    public function storeLocation(Request $request)
    {
        $location = BusinessLocation::orderBy('location_id', 'DESC')->first();
        if ( is_null($location) ){
            $loc_id = 001;
        }else {
            $loc_id = str_replace('BL', '', $location->location_id) * 1 + 1;
        }

        $location = new BusinessLocation;
        $location->location_id = 'BL' . str_pad($loc_id, 3, '0', STR_PAD_LEFT);
        $location->business_id = $request->business_id;
        $location->name = $request->name;
        $location->country = $request->country;
        $location->state = $request->state;
        $location->city = $request->city;
        $location->zip_code = $request->zip_code;
        $location->address = $request->address;
        $location->mobile = $request->mobile;
        $location->alternate_number = $request->alternate_number;
        $location->email = $request->email;
        $location->printer_id = $request->printer_id;
        $location->is_active = 1;

        if ( $location->save() ){
            toastr()->success("Location has been Created .");
            return redirect()->route('business.locations');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('business.locations');
        }
    }

    public function editLocation($id) 
    {
        $location = BusinessLocation::find($id);
        $business = Business::get();
        $title = "Edit Location";
        return view('business.edit-location', compact('title', 'business', 'location'));
    }

    public function updateLocation(Request $request)
    {
        $location = BusinessLocation::find($request->id);
        $location->business_id = $request->business_id;
        $location->name = $request->name;
        $location->country = $request->country;
        $location->state = $request->state;
        $location->city = $request->city;
        $location->zip_code = $request->zip_code;
        $location->address = $request->address;
        $location->mobile = $request->mobile;
        $location->alternate_number = $request->alternate_number;
        $location->email = $request->email;
        $location->printer_id = $request->printer_id;
        $location->is_active = 1;

        if ( $location->save() ){
            toastr()->success("Location has been Updated .");
            return redirect()->route('business.locations');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('business.locations');
        }
    }

    public function deleteLocation($id)
    {
        if ( BusinessLocation::destroy($id) ){
            toastr()->success('Location has been deleted.');
            return redirect()->route('business.locations');
        }else {
            toastr()->error('Opss!... something wrong.');
            return redirect()->route('business.locations');
        }
    }
}
