php artisan make:model --migration --controller Admin
php artisan make:model --migration --controller Artikel
php artisan make:model --migration --controller Attribute
php artisan make:model --migration --controller AttributeSablon
php artisan make:model --migration --controller Banner --resource  
php artisan make:model --migration --controller BuyCourcef
php artisan make:model --migration --controller BuyCourcen
php artisan make:model --migration --controller CartFCource --resource  
php artisan make:model --migration --controller CartLaundry
php artisan make:model --migration --controller CartNCource --resource  
php artisan make:model --migration --controller CartProduct
php artisan make:model --migration --controller CartSablon
php artisan make:model --migration --controller Category
php artisan make:model --migration --controller CeritaDonation
php artisan make:model --migration --controller City
php artisan make:model --migration --controller CommentFCource --resource   
php artisan make:model --migration --controller CommentForum --resource   
php artisan make:model --migration --controller CommentLaundry --resource  
php artisan make:model --migration --controller CommentNCource --resource   
php artisan make:model --migration --controller CommentProduct --resource  
php artisan make:model --migration --controller CommentSablon --resource  
php artisan make:model --migration --controller Contact
php artisan make:model --migration --controller Coupon
php artisan make:model --migration --controller Discountcf --resource  
php artisan make:model --migration --controller Discountcn --resource  
php artisan make:model --migration --controller Discountl --resource  
php artisan make:model --migration --controller Discountp --resource  
php artisan make:model --migration --controller Discounts --resource  
php artisan make:model --migration --controller Donation
php artisan make:model --migration --controller Donatur
php artisan make:model --migration --controller Faq
php artisan make:model --migration --controller Forum
php artisan make:model --migration --controller Gender
php artisan make:model --migration --controller JenisSablon
php artisan make:model --migration --controller Laundry
php artisan make:model --migration --controller LikeForum
php artisan make:model --migration --controller Lookbook
php artisan make:model --migration --controller MaterialSablon
php artisan make:model --migration --controller OfflineCource
php artisan make:model --migration --controller OnlineCource
php artisan make:model --migration --controller Order
php artisan make:model --migration --controller OrderCoupon
php artisan make:model --migration --controller OrderCourcef
php artisan make:model --migration --controller OrderCourcen
<!-- php artisan make:model --migration --controller OrderDonatur -->
php artisan make:model --migration --controller OrderLaundry
php artisan make:model --migration --controller OrderProduct
php artisan make:model --migration --controller OrderSablon
php artisan make:model --migration --controller Patner
php artisan make:model --migration --controller Payment
php artisan make:model --migration --controller PostingOfflineCource
php artisan make:model --migration --controller PostingOnlineCource
php artisan make:model --migration --controller Product
php artisan make:model --migration --controller ProductColor
php artisan make:model --migration --controller ProductSize
php artisan make:model --migration --controller Province
php artisan make:model --migration --controller PusatBantuan
php artisan make:model --migration --controller RatingFCource --resource
php artisan make:model --migration --controller RatingLaundry --resource  
php artisan make:model --migration --controller RatingNCource --resource  
php artisan make:model --migration --controller RatingProduct --resource  
php artisan make:model --migration --controller RatingSablon --resource  
<!-- php artisan make:model --migration --controller RekeningBank -->
php artisan make:model --migration --controller Sablon
php artisan make:model --migration --controller Seller
php artisan make:model --migration --controller Social
php artisan make:model --migration --controller UserAddres
php artisan make:model --migration --controller Verifikasi


./ngrok authtoken 1qFQq5q08Xd5tPhg95jj2CagkZr_5FAYvgBf7kd8MqecTGxmc
./ngrok help
To start a HTTP tunnel forwarding to your local port 80, run this next:
./ngrok http 80
ngrok config add-authtoken 1qFQq5q08Xd5tPhg95jj2CagkZr_5FAYvgBf7kd8MqecTGxmc

ngrok.exe authtoken 1qFQq5q08Xd5tPhg95jj2CagkZr_5FAYvgBf7kd8MqecTGxmc
ngrok.exe http 80
 
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled
php artisan config:cache

ngrok config add-authtoken 2hzhkaj58RMepkecSptyySWicpw_5g4fxkG3YsFEQgtV54qLV
ngrok http http://localhost:8080

ngrok http http://localhost:80

ngrok authtoken 2hzhkaj58RMepkecSptyySWicpw_5g4fxkG3YsFEQgtV54qLV


php artisan migrate:fresh --seed

php artisan make:model --migration --controller Admin
php artisan make:model --migration --controller Banner
php artisan make:model --migration --controller Blog --resource 
php artisan make:model --migration --controller Cart
php artisan make:model --migration --controller City
php artisan make:model --migration --controller CityPrice
php artisan make:model --migration --controller Company
php artisan make:model --migration --controller Contact
php artisan make:model --migration --controller Order
php artisan make:model --migration --controller Payment
php artisan make:model --migration --controller Product
php artisan make:model --migration --controller ProductCar
php artisan make:model --migration --controller ProductImage
php artisan make:model --migration --controller ProductName
php artisan make:model --migration --controller Province
php artisan make:model --migration --controller Seller
php artisan make:model --migration --controller SellerPayment

php artisan make:model --migration --controller AddOn


php artisan make:model --migration --controller Company --resource   

php artisan make:model --migration --controller CityPrice

composer self-update
php artisan clear-compiled 
composer dump-autoload
php artisan optimize

php artisan make:model --migration --controller Cart
php artisan make:model --migration --controller Order

php artisan make:model --migration --controller ProductName --resource   
php artisan make:model --migration --controller ProductImage --resource  
 <!-- sendemail attactment pdf -->

public function sendmail(Request $request){
        $data["email"]=$request->get("email");
        $data["client_name"]=$request->get("client_name");
        $data["subject"]=$request->get("subject");

        $pdf = PDF::loadView('mails.mail', $data);

        try{
            Mail::send('mails.mail', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "invoice.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
 }

 <!-- sendemail  pdf -->

 public function sendmail(Request $request){
        $data["email"]=$request->get("email");
        $data["client_name"]=$request->get("client_name");
        $data["subject"]=$request->get("subject");

        $files = [
                public_path('attachments/demo.jpeg'),
                public_path('attachments/tariff_rates.pdf'),
            ];

        try{
            
            Mail::send('mails.mail', $data, function($message)use($data,$files) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"]);

            foreach ($files as $file){
                    $message->attach($file);
                }  
            });

        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";

        }else{

           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
    }

        $mainRecipients = ['main1@example.com', 'main2@example.com'];
        $ccRecipients = ['cc1@example.com', 'cc2@example.com'];
        $bccRecipients = ['secret1@example.com', 'secret2@example.com'];
        $name = "Funny Coder"; // Dynamic content

        Mail::to($mainRecipients)
            ->cc($ccRecipients)
            ->bcc($bccRecipients)
            ->send(new MyTestEmail($name));
        
        Route::get('/sendWithAttachment', function() {
        $name = "Funny Coder";
        $filePath = 'path/to/your/file.pdf';  // Ensure the path is correct

        // The email sending is done using the to method on the Mail facade
        Mail::to('testreceiver@gmail.com')->send(new MyTestEmail($name, $filePath));
    });

    $data["email"]= "ownhabits@gmail.com";
        $data["title"]= "From carengibran@gmail.com";
        $data["body"]= "This is Demo";

        $pdf = PDF::loadView('FrontEnd.invoice2', $data);

        Storage::put('public/images/invoice.pdf', $pdf->output());

        return $pdf->download('invoice.pdf');

        ->attachData($pdf->output(), rand(1,50). '.' . 'pdf');

        use Barryvdh\DomPDF\Facade\Pdf;
        use Illuminate\Support\Facades\Mail;
        use Illuminate\Support\Str;


        $data["email"] = "aatmaninfotech@gmail.com";

        $data["title"] = "From ItSolutionStuff.com";

        $data["body"] = "This is Demo";

  

        $pdf = PDF::loadView('emails.myTestMail', $data);

  

        Mail::send('emails.myTestMail', $data, function($message)use($data, $pdf) {

            $message->to($data["email"], $data["email"])

                    ->subject($data["title"])

                    ->attachData($pdf->output(), "text.pdf");

        });

  

        dd('Mail sent successfully');


        $pdf = PDF::loadView('load-pdf')->setOptions(['defaultFont' => 'sans-serif']);

        namespace App\Http\Controllers;
       
        use Illuminate\Http\Request;
        use App\Mail\MailExample;
        use PDF;
        use Mail;
            
        class PDFController extends Controller
        {
            
            /**
            * Show the application dashboard.
            *
            * @return \Illuminate\Http\Response
            */
            public function index()
            {
                $data["email"] = "your@gmail.com";
                $data["title"] = "From ItSolutionStuff.com";
                $data["body"] = "This is Demo";
            
                $pdf = PDF::loadView('emails.myTestMail', $data);
                $data["pdf"] = $pdf;
        
                Mail::to($data["email"])->send(new MailExample($data));
            
                dd('Mail sent successfully');
            }
            
        }


        

        namespace App\Http\Controllers;

        

        use PDF;

        use Mail;

        

        class PDFController extends Controller

        {

            /**

            * Write code on Method

            *

            * @return response()

            */

            public function index()

            {

                $data["email"] = "aatmaninfotech@gmail.com";

                $data["title"] = "From ItSolutionStuff.com";

                $data["body"] = "This is Demo";

        

                $files = [

                    public_path('files/160031367318.pdf'),

                    public_path('files/1599882252.png'),

                ];

        

                Mail::send('emails.myTestMail', $data, function($message)use($data, $files) {

                    $message->to($data["email"], $data["email"])

                            ->subject($data["title"]);

        

                    foreach ($files as $file){

                        $message->attach($file);

                    }

                    

                });

        

                dd('Mail sent successfully');

            }

        }

        namespace App\Http\Controllers;
  
        use Illuminate\Http\Request;
        use Barryvdh\DomPDF\Facade\Pdf;
        
        class InvoiceController extends Controller
    
            /**
            * Write code on Method
            *
            * @return response()
            */
            public function index(Request $request)
            {
                $data = [
                    [
                        'quantity' => 2,
                        'description' => 'Gold',
                        'price' => '$500.00'
                    ],
                    [
                        'quantity' => 3,
                        'description' => 'Silver',
                        'price' => '$300.00'
                    ],
                    [
                        'quantity' => 5,
                        'description' => 'Platinum',
                        'price' => '$200.00'
                    ]
                ];
            
                $pdf = Pdf::loadView('invoice', ['data' => $data]);
            
                return $pdf->download();
            }

    <!-- namespace App\Http\Controllers;
    use App\Item;
    use App\ItemDetail;
    use Illuminate\Http\Request;

    class UploadController extends Controller
    {

    public function uploadForm()
    {

    return view('upload_form');
    }
    
    public function uploadSubmit(Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'photos'=>'required',
        ]);
        if($request->hasFile('photos'))
        {

        $allowedfileExtension=['pdf','jpg','png','docx'];
        $files = $request->file('photos');
        foreach($files as $file){
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $check=in_array($extension,$allowedfileExtension);
        dd($check);
        if($check)
        {

        $items= Item::create($request->all());
        foreach ($request->photos as $photo) {
        $filename = $photo->store('photos');
        ItemDetail::create([
        'item_id' => $items->id,
        'filename' => $filename
        ]);
    }
    echo "Upload Successfully";
    }

    else
    {

    echo '<div class="alert alert-warning"><strong>Warning!</strong> Sorry Only Upload png , jpg , doc</div>';
    }

    }

    }

    } -->

 <!-- sendemail  pdf -->

 php artisan make:model --migration --controller ProductCar


 https://www.itsolutionstuff.com/post/laravel-11-generate-pdf-and-send-email-tutorialexample.html
 https://www.itsolutionstuff.com/post/laravel-10-generate-pdf-and-send-email-exampleexample.html
 https://www.itsolutionstuff.com/post/how-to-generate-pdf-and-send-email-in-laravelexample.html
 https://www.itsolutionstuff.com/post/laravel-mail-send-with-pdf-attachment-exampleexample.html
 https://support.google.com/mail/answer/185833?hl=en
 https://myaccount.google.com/apppasswords?rapt=AEjHL4MIRzkJensoDqeAfw0QWFBFAx2ZY5Hlt9Az3FOSd2Bup4C9YWKkExLTr-TecDPrh9Rzk7UoUi0erV2VYBqUeQzFirrxaifvezk680Byso8y-5038Ls


 git  


git reset --mixed origin/main
git add .
git commit -m "This is a new commit for what I originally planned to be amended"
git push origin main

# add and commit first
#
git push -u origin main

# Or git 2.37 Q2 2022+
git config --global push.autoSetupRemote true
git push

(Note: starting Oct. 2020, any new repository is created with the default branch main, not master. And you can rename existing repository default branch from master to main.
The rest of this 2014 answer has been updated to use "main")

(The following assumes github.com itself is not down, as eri0o points out in the comments: see www.githubstatus.com to be sure)

If the GitHub repo has seen new commits pushed to it, while you were working locally, I would advise using:

git pull --rebase
git push
The full syntax is:

git pull --rebase origin main
git push origin main
With Git 2.6+ (Sept. 2015), after having done (once)

git config --global pull.rebase true
git config --global rebase.autoStash true

See a more complete example in the chapter 6 Pull with rebase of the Git Pocket Book.

I would recommend a:

# add and commit first
#
git push -u origin main

# Or git 2.37 Q2 2022+
git config --global push.autoSetupRemote true
git push
That would establish a tracking relationship between your local main branch and its upstream branch.
After that, any future push for that branch can be done with a simple:

git push

git reset --mixed origin/main
git add .
git commit -m "This is a new commit for what I originally planned to be amended"
git push origin main
There is no need to pull --rebase.

Note: git reset --mixed origin/main can also be written git reset origin/main, since the --mixed option is the default one when using git reset.


66

It has worked for me with this combination of several command lines:

git reset 
git remote -v
git pull --rebase
git init
git add -A
git commit -m "Add your commit"
git branch -M main
git push origin main --force
Be careful. If they have a Readme file, the git reset deletes them.


git init

git remote add origin https://gitlab.com/crew-chief-systems/bot

git remote -v (for checking current repository)

git add -A(add all files)

git commit -m 'Added my project'

git pull --rebase origin master

git push  origin master

rm -rf .git
git init
 git add .
 git commit -m"first message"
 git remote add origin "LINK"
 git push -u origin master

 https://support.niagahoster.co.id/
 https://support.niagahoster.co.id/

 …or create a new repository on the command line
echo "# apy-rent-a-car" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M main
git remote add origin https://github.com/affandymargareta/apy-rent-a-car.git
git push -u origin main
…or push an existing repository from the command line
git remote add origin https://github.com/affandymargareta/apy-rent-a-car.git
git branch -M main
git push -u origin main


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="u623912798_apyrentacar"
DB_USERNAME="u623912798_apyrentacar"
DB_PASSWORD="@Affandymargareta#105"


<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^(.*)$ public/$1 [L]

</IfModule>
<IfModule mod_rewrite.c>

RewriteEngine On 
RewriteCond %{HTTPS} off 
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

</IfModule>
<!-- Facebook -->
<i class="fab fa-facebook-f fa-2x" style="color: #3b5998;"></i>

<!-- Twitter -->
<i class="fab fa-twitter fa-2x" style="color: #55acee;"></i>

<!-- Google -->
<i class="fab fa-google fa-2x" style="color: #dd4b39;"></i>

<!-- Instagram -->
<i class="fab fa-instagram fa-2x" style="color: #ac2bac;"></i>

<!-- Linkedin -->
<i class="fab fa-linkedin-in fa-2x" style="color: #0082ca;"></i>

<!-- Pinterest -->
<i class="fab fa-pinterest fa-2x" style="color: #c61118;"></i>

<!-- Vkontakte -->
<i class="fab fa-vk fa-2x" style="color: #4c75a3;"></i>

<!-- Stack overflow -->
<i class="fab fa-stack-overflow fa-2x" style="color: #ffac44;"></i>

<!-- Youtube -->
<i class="fab fa-youtube fa-2x" style="color: #ed302f;"></i>

<!-- Slack -->
<i class="fab fa-slack-hash fa-2x" style="color: #481449;"></i>

<!-- Github -->
<i class="fab fa-github fa-2x" style="color: #333333;"></i>

<!-- Dribbble -->
<i class="fab fa-dribbble fa-2x" style="color: #ec4a89;"></i>

<!-- Reddit -->
<i class="fab fa-reddit-alien fa-2x" style="color: #ff4500;"></i>

<!-- Whatsapp -->
<i class="fab fa-whatsapp fa-2x" style="color: #25d366;"></i>