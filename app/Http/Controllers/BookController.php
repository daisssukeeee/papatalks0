<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function approve($bookId)
    {
    $book = Book::find($bookId);
    $book->status = 'matching'; // ステータスをマッチングに更新
    $book->save();

    return back()->with('success', '申込みを承認しました。');
    }
}
