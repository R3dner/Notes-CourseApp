<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class NoteController extends AbstractController
{

    private const PAGE_SIZE = 10;

    public function createAction(): void{

        if($this->request->hasPost()){
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];

            $this->database->createNote($noteData);

            $this->redirect('/', ['before' => 'created']);
        }
        $this->view->render('create');
    }

    public function showAction(): void{

        $note = $this->getNote();

        $this->view->render(
            'show',
            ['note' => $note]
        );
    }

    public function listAction(): void{
        $phrase = $this->request->getParam('phrase');
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
        $pageNumber = (int) $this->request->getParam('page', 1);
        $sortBy = $this->request->getParam('sortby', 'title');
        $orderBy = $this->request->getParam('orderby', 'asc');

        if(!in_array($pageSize, [1, 5, 10, 25])){
            $pageSize = self::PAGE_SIZE;
        }

        if($phrase){
            $notes = $this->noteModel->search($phrase, $pageNumber, $pageSize, $sortBy, $orderBy);
            $notesCount = $this->noteModel->searchCount($phrase);
        } else {
            $notes = $this->noteModel->list($pageNumber, $pageSize, $sortBy, $orderBy);
            $notesCount = $this->noteModel->count();
        }


        $viewParams = [
            'before' => $this->request->getParam('before'),
            'notes' => $notes,
            'error' => $this->request->getParam('error'),
            'sort' => [
                'by' => $sortBy,
                'order' => $orderBy
            ],
            'page' => [
                'number' => $pageNumber,
                'size' => $pageSize,
                'pages' => (int) ceil($notesCount/$pageSize)
            ],
            'phrase' => $phrase
        ];

        $this->view->render('list', $viewParams ?? []);
    }

    public function editAction(): void{

        if($this->request->isPost()){
            $noteId = (int) $this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->noteModel->edit($noteId, $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }
        

        $note = $this->getNote();

        $viewParams = [
            'note' => $note,
        ];

        $this->view->render(
            'edit',
            $viewParams
        );
    }

    public function deleteAction(){

        if($this->request->isPost()){
            $id = $this->request->postParam('id');
            $this->noteModel->delete($id);
            $this->redirect('/', ['before' => 'deleted']);
        }

        $note = $this->getNote();
        
        $viewParams = [
            'note' => $note,
        ];

        $this->view->render(
            'delete',
            $viewParams
        );
    }

    private function getNote(): array{
        $noteId = (int) $this->request->getParam('id');
        if(!$noteId){
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
            $note = $this->noteModel->get($noteId);

        return $note;
    }
}
