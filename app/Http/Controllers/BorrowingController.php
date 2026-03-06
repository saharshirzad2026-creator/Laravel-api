<?php

namespace App\Http\Controllers;
use App\Http\Requests\BorrowingUpdateRequest;
use App\Http\Resources\BorrowingResource;
use App\Http\Requests\BorrowingInsertRequest;
use App\Models\Borrowing;
use App\models\Book;

use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $borrowings = Borrowing::with(['book','member'])->paginate(10);
        return BorrowingResource::collection($borrowings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BorrowingInsertRequest $request)
    {
        //
        try{
        $book = Book::findOrFail($request->book_id);
        if($book->available_copies>0){
            $borrowing = Borrowing::create($request->validated());
            $book->update([
                "available_copies"=> $book->available_copies--,
            ]);
            $borrowing->load(['member','book']);
            return new BorrowingResource($borrowing);
        }
        }catch(Exception $error){
            return response()->json([
                "message"=> $error->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->load(['book','member']);
        return new BorrowingResource($borrowing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function returnBook(Borrowing $borrowing){
        if($borrowing->status !=='borrowed'){
            return response()->json([
                "message"=> "The book has already been returned"
            ]);
        }
        else{
        $borrowing->update([
            "returned_date"=>now(),
            "status"=> "returned"
        ]);
        $borrowing->book->returnBook();
        $borrowing->load(['member','book']);
        return new BorrowingResource($borrowing);
    }
    }
    public function overdue(){
        $overdueBorrowings = Borrowing::with(['book','member'])
        ->where('status','borrowed')
        ->where('due_date','<',now())
        ->get();


        Borrowing::where('status','borrowed')
        ->where('due_date','<', now())
        ->where(['status'=> 'overdue']);
        return BorrowingResource::collection($overdueBorrowings);
    }
}
//     public function update(BorrowingUpdateRequest $request, string $id)
//     {
//         //
//         try{
//             $borrowing = Borrowing::findOrFail($id);
//             $borrowing->update($request->validated());
//             return new BorrowingResource($borrowing);
//         }
//         catch(Exception $error){
//             return response()->json([
//                 "message"=> $error->getMessage(),
//             ]);
//         }
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         //
//     }
// }
