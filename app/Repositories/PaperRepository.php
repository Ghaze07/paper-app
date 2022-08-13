<?php

namespace App\Repositories;

use App\Models\Paper;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\IPaper;

class PaperRepository implements IPaper
{
    public function uploadPaper($request)
    {
        DB::beginTransaction();
        
        try {

            if ($request->hasFile('question_paper')) {
                
                $questionPaper = time().'_question_paper_'.$request->file('question_paper')
                                                                    ->getClientOriginalName();
                
                $questionFilePath = $request->file('question_paper')
                                                ->storeAs('papers', str_replace(' ', '_', $questionPaper), 'public');
            }

            if ($request->answer_type == Paper::ANSWER_TYPE_FILE && $request->hasFile('answer_paper')) {
                $answerPaper = time().'_answer_paper_'.$request->file('answer_paper')
                                                                    ->getClientOriginalName();
                
                $answerFilePath = $request->file('answer_paper')
                                                ->storeAs('papers', str_replace(' ', '_', $answerPaper), 'public');
                
                $answerText = null;
            }

            if ($request->answer_type == Paper::ANSWER_TYPE_TEXT) {
                $answerPaper = null;
                $answerFilePath = null;
                $answerText = $request->answer_text;
            }

            Paper::create([
                'subject_id' => $request->subject_id,
                'question_file_name' => $questionPaper,
                'question_file_path' => $questionFilePath,
                'answer_type' => $request->answer_type,
                'answer_text' => $answerText,
                'answer_file_name' => $answerPaper,
                'answer_file_path' => $answerFilePath,
                'date' => $request->date,
            ]);

            DB::commit();

            return true;

        } catch (\Exception $ex) {
            
            DB::rollBack();
            return $ex;
        }
        
    }

    public function findPaperById($paperId)
    {
        return Paper::findOrFail($paperId);
    }

    public function updatePaper($paper, $request)
    {
        DB::beginTransaction();
        try {
            
            if ($request->has('question_paper') && $request->hasFile('question_paper')) {
                $paper->deleteExistingQuestionPaper();
    
                $questionPaper = time().'_question_paper_'.$request->file('question_paper')
                                                                        ->getClientOriginalName();
                    
                $questionFilePath = $request->file('question_paper')
                                            ->storeAs('papers', $questionPaper, 'public');
                
                $paper->question_file_name = $questionPaper;
                $paper->question_file_path = $questionFilePath;
            }

            if ($request->answer_type == Paper::ANSWER_TYPE_FILE && $request->has('answer_paper') && $request->hasFile('answer_paper')) {
                $paper->deleteExistingAnswerPaper();
    
                $answerPaper = time().'_answer_paper_'.$request->file('answer_paper')
                                                                ->getClientOriginalName();
                    
                $answerFilePath = $request->file('answer_paper')
                                            ->storeAs('papers', $answerPaper, 'public');
    
                $paper->answer_file_name = $answerPaper;
                $paper->answer_file_path = $answerFilePath;
            }
    
            if ($request->answer_type == Paper::ANSWER_TYPE_TEXT && $request->has('answer_text')) {
                $paper->answer_text = $request->answer_text;
            }
    
            if ($request->has('date')) {
                $paper->date = $request->date;
            }

            $paper->subject_id = $request->subject_id;
    
            $paper->save();
            
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
        }
        

        
    }
}
