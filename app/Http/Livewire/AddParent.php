<?php

namespace App\Http\Livewire;
use App\Models\Parents;
use App\Models\Nationalitie;
use App\Models\Religion;
use App\Models\parentAttachment;
use App\Models\Blood_type;
use App\Models\Image;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class AddParent extends Component
{

    use WithFileUploads;

    public $successMessage = '';

    public $catchError , $updateMode = false , $photos , $show_table = true;


    public $currentStep = 1,    

        // Father_INPUTS
        $Email, $Password,
        $Name_Father, $Name_Father_en,
        $National_ID_Father, $Passport_ID_Father,
        $Phone_Father, $Job_Father, $Job_Father_en,
        $Nationality_Father_id, $Blood_Type_Father_id,
        $Address_Father, $Religion_Father_id,

        // Mother_INPUTS
        $Name_Mother, $Name_Mother_en,
        $National_ID_Mother, $Passport_ID_Mother,
        $Phone_Mother, $Job_Mother, $Job_Mother_en,
        $Nationality_Mother_id, $Blood_Type_Mother_id,
        $Address_Mother, $Religion_Mother_id;


        public function updated($propertyName)
            {
                $this->validateOnly($propertyName, [
                    'Email' => 'required|email',
                    'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                    'Passport_ID_Father' => 'min:10|max:10',
                    'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                    'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
                    'Passport_ID_Mother' => 'min:10|max:10',
                    'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
                ]);
            }
    
    public function render()
    {
        return view('livewire.add-parent', [
            'Nationalities' => Nationalitie::all(),
            'Type_Bloods' => Blood_type::all(),
            'Religions' => Religion::all(),
            'Parents' => Parents::all(),
        ]);
    }

    public function show_add_form() {
        $this->show_table = false ;
    }

    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $Parents = Parents::where('id',$id)->first();
        $this->Parent_id = $id;
        $this->Email = $Parents->Email;
        $this->Password = $Parents->Password;
        $this->Name_Father = $Parents->getTranslation('Name_Father', 'ar');
        $this->Name_Father_en = $Parents->getTranslation('Name_Father', 'en');
        $this->Job_Father = $Parents->getTranslation('Job_Father', 'ar');;
        $this->Job_Father_en = $Parents->getTranslation('Job_Father', 'en');
        $this->National_ID_Father =$Parents->National_ID_Father;
        $this->Passport_ID_Father = $Parents->Passport_ID_Father;
        $this->Phone_Father = $Parents->Phone_Father;
        $this->Nationality_Father_id = $Parents->Nationality_Father_id;
        $this->Blood_Type_Father_id = $Parents->Blood_Type_Father_id;
        $this->Address_Father =$Parents->Address_Father;
        $this->Religion_Father_id =$Parents->Religion_Father_id;

        $this->Name_Mother = $Parents->getTranslation('Name_Mother', 'ar');
        $this->Name_Mother_en = $Parents->getTranslation('Name_Father', 'en');
        $this->Job_Mother = $Parents->getTranslation('Job_Mother', 'ar');;
        $this->Job_Mother_en = $Parents->getTranslation('Job_Mother', 'en');
        $this->National_ID_Mother =$Parents->National_ID_Mother;
        $this->Passport_ID_Mother = $Parents->Passport_ID_Mother;
        $this->Phone_Mother = $Parents->Phone_Mother;
        $this->Nationality_Mother_id = $Parents->Nationality_Mother_id;
        $this->Blood_Type_Mother_id = $Parents->Blood_Type_Mother_id;
        $this->Address_Mother =$Parents->Address_Mother;
        $this->Religion_Mother_id =$Parents->Religion_Mother_id;
    }


    //firstStepSubmit
    public function firstStepSubmit_edit()
    {
        $this->validate([
            'Email' => 'required|unique:parents,Email,'.$this->Parent_id,
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:parents,National_ID_Father,' . $this->Parent_id,
            'Passport_ID_Father' => 'required|unique:parents,Passport_ID_Father,' . $this->Parent_id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);

        $this->updateMode = true;
        $this->currentStep = 2;

    }

    //secondStepSubmit_edit
    public function secondStepSubmit_edit()
    {

        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:parents,National_ID_Mother,' . $this->Parent_id,
            'Passport_ID_Mother' => 'required|unique:parents,Passport_ID_Mother,' . $this->Parent_id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);
        
        $this->updateMode = true;
        $this->currentStep = 3;

    }

    public function submitForm_edit(){

        if ($this->Parent_id){
            $parent = Parents::find($this->Parent_id);
            $parent->update([
                'Email' => $this->Email,
                'Password' => Hash::make($this->Password),
                'Name_Father' => ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father],
                'National_ID_Father' => $this->National_ID_Father,
                'Passport_ID_Father' => $this->Passport_ID_Father,
                'Phone_Father' => $this->Phone_Father,
                'Job_Father' => ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father],
                'Passport_ID_Father' => $this->Passport_ID_Father,
                'Nationality_Father_id' => $this->Nationality_Father_id,
                'Blood_Type_Father_id' => $this->Blood_Type_Father_id,
                'Religion_Father_id' => $this->Religion_Father_id,
                'Address_Father' => $this->Address_Father,

                // Mother_INPUTS
                'Name_Mother' => ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother],
                'National_ID_Mother' => $this->National_ID_Mother,
                'Passport_ID_Mother' => $this->Passport_ID_Mother,
                'Phone_Mother' => $this->Phone_Mother,
                'Job_Mother' => ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother],
                'Passport_ID_Mother' => $this->Passport_ID_Mother,
                'Nationality_Mother_id' => $this->Nationality_Mother_id,
                'Blood_Type_Mother_id' => $this->Blood_Type_Mother_id,
                'Religion_Mother_id' => $this->Religion_Mother_id,
                'Address_Mother' => $this->Address_Mother,
            ]);

            if (!empty($this->photos)){
                foreach ($this->photos as $photo) {
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    ParentAttachment::create([
                        'file_name' => Hash::make($photo->getClientOriginalName()),
                        'parent_id' => Parents::latest()->first()->id,
                    ]);
                }
            }
            
            $this->successMessage = trans('message.success');
            $this->show_table = true;
            $this->updateMode = false;
        }

        return redirect()->to('/add_parent');
    }


    public function delete($id){
        Parents::findOrFail($id)->delete();
        return redirect()->to('/add_parent');
    }

    public function firstStepSubmit()
    {

        $this->validate([
            'Email' => 'required|unique:parents,Email,' . $this->id,
            'Password' => 'required',
            'Name_Father' => 'required',
            'Name_Father_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:parents,National_ID_Father,' . $this->id,
            'Passport_ID_Father' => 'required|unique:parents,Passport_ID_Father,' . $this->id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);


        $this->currentStep = 2;
    }

    //secondStepSubmit
    public function secondStepSubmit()
    {
        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:parents,National_ID_Mother,' . $this->id,
            'Passport_ID_Mother' => 'required|unique:parents,Passport_ID_Mother,' . $this->id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);

        $this->currentStep = 3;
    }


    


    public function submitForm(){


        

        try {
            $Parents = new Parents();
            // Father_INPUTS
            $Parents->Email = $this->Email;
            $Parents->Password = Hash::make($this->Password);
            $Parents->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $Parents->National_ID_Father = $this->National_ID_Father;
            $Parents->Passport_ID_Father = $this->Passport_ID_Father;
            $Parents->Phone_Father = $this->Phone_Father;
            $Parents->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $Parents->Passport_ID_Father = $this->Passport_ID_Father;
            $Parents->Nationality_Father_id = $this->Nationality_Father_id;
            $Parents->Blood_Type_Father_id = $this->Blood_Type_Father_id;
            $Parents->Religion_Father_id = $this->Religion_Father_id;
            $Parents->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $Parents->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $Parents->National_ID_Mother = $this->National_ID_Mother;
            $Parents->Passport_ID_Mother = $this->Passport_ID_Mother;
            $Parents->Phone_Mother = $this->Phone_Mother;
            $Parents->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $Parents->Passport_ID_Mother = $this->Passport_ID_Mother;
            $Parents->Nationality_Mother_id = $this->Nationality_Mother_id;
            $Parents->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
            $Parents->Religion_Mother_id = $this->Religion_Mother_id;
            $Parents->Address_Mother = $this->Address_Mother;
            $Parents->save();

            if (!empty($this->photos)){
                foreach ($this->photos as $photo) {

                    $image_name = $photo->getClientOriginalName();
                    // $image_extension = $photo->getClientOriginalExtension();
                  
                    // $images= new Image();
                    // $images->file_name=$image_name;
                    // $images->imageable_name= $Parents->id;
                    // $images->image_able_type = 'Parents::class';
                    // $images->save();

                    Image::create([
                        'file_name' => $image_name,
                        'imageable_id' => $Parents->id,
                        'imageable_type' => 'Parents::class',
                    ]);

                    $photo->storeAs('attachments/parents/' . $Parents->id . '-' . $Parents->Name_Father , $image_name , $disk ='upload_attachments');
                }
            }

            
           
            $this->successMessage = trans('message.success');

            // لو عاوزه يرجع على جدول المعلومات
            // $this->show_table = true;
            // $this->updateMode = false;

            // لو عاوزه يرجع على جدول ااضافه اب فاضى
            $this->clearForm();
            $this->currentStep = 1;
        }

        catch (\Exception $e) {
            
            $this->catchError = $e->getMessage();
        };



    }

    //clearForm
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }

    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }
}
