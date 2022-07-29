package jahrulnr.e_diagnosticsuir.activity;

import static com.beardedhen.androidbootstrap.font.FontAwesome.FA_ARROW_LEFT;
import static com.beardedhen.androidbootstrap.font.FontAwesome.FA_ARROW_RIGHT;
import static jahrulnr.e_diagnosticsuir.lib.getJSON;
import static jahrulnr.e_diagnosticsuir.lib.getJSONArray;
import static jahrulnr.e_diagnosticsuir.lib.getJSONObject;
import static jahrulnr.e_diagnosticsuir.lib.getJSONString;
import static jahrulnr.e_diagnosticsuir.lib.getRequest;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import com.beardedhen.androidbootstrap.BootstrapButton;
import com.beardedhen.androidbootstrap.BootstrapLabel;
import com.beardedhen.androidbootstrap.BootstrapText;
import com.beardedhen.androidbootstrap.TypefaceProvider;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import jahrulnr.e_diagnosticsuir.R;
import jahrulnr.e_diagnosticsuir.config;
import jahrulnr.e_diagnosticsuir.custom.soalManager;

public class tesMateri extends AppCompatActivity {

    private final String filename = new config().filename;
    private String token, id_materi, judul_materi;
    Intent intent;
    private LinearLayout loading;
    private soalManager sManager = null;
    private BootstrapButton refresh;

    private TextView id_soal, soal;
    private BootstrapLabel no_soal, bobot;
    private EditText jawaban;
    private BootstrapButton btnPrev, btnNext, btnSubmit, about;
    private int show_soal = 0;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Set window bar
        Window window = getWindow();
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        window.setStatusBarColor(ContextCompat.getColor(this, R.color.bootstrap_gray));
    }

    @Override
    protected void onStart() {
        super.onStart();
        TypefaceProvider.registerDefaultIconSets();
        setContentView(R.layout.materi_tes);

        // Get Data
        intent = getIntent();
        token = intent.getStringExtra("_token");
        id_materi = intent.getStringExtra("id_materi");

//         if jumping activity
        if(token.isEmpty() || id_materi.isEmpty())
            back2Login();

        judul_materi = intent.getStringExtra("judul_materi");
        loading = findViewById(R.id.login_container);
        about = findViewById(R.id.about);
        about.setVisibility(View.GONE);

        id_soal = findViewById(R.id.id_soal);
        soal = findViewById(R.id.soal);
        no_soal = findViewById(R.id.no_soal);
        bobot = findViewById(R.id.bobot);
        jawaban = findViewById(R.id.jawaban);

        btnPrev = findViewById(R.id.btnPrev);
        btnNext = findViewById(R.id.btnNext);
        btnSubmit = findViewById(R.id.kirim_jawaban);

        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.GONE);
        BootstrapLabel judul_materi = findViewById(R.id.judul_materi);
        judul_materi.setText(this.judul_materi);

        setLoading(true);
        ExecutorService executor = Executors.newSingleThreadExecutor();
        executor.execute(() -> {
            String req = getRequest("android/materi/" + id_materi + "/soal/" + token);
            JSONArray data_soal = getJSONArray(req);
            runOnUiThread(()->{
                if(data_soal == null){
                    Toast.makeText(getApplicationContext(),
                            "Tidak ada data.",
                            Toast.LENGTH_LONG);
                }else {
                    sManager = new soalManager(data_soal);
                    setSoal(sManager);
                }

                setLoading(false);
            });
        });

        btnSubmit.setOnClickListener(view -> {
            sManager.setJawaban(show_soal, jawaban);
            if(!sManager.isFull())
                Toast.makeText(
                        getApplicationContext(),
                        "Semua soal harus diisi.",
                        Toast.LENGTH_LONG
                ).show();
            else {
                if(sManager.getJawaban() != null) {
                    new AlertDialog.Builder(this)
                        .setMessage("Serahkan Jawaban?")
                        .setNegativeButton("Tidak", null)
                        .setPositiveButton("Ya", (arg0, arg1) -> {
                            setLoading(true);
                            executor.execute(() -> {
                                String req = getRequest("android/simpan/jawaban/" + token, sManager.getQueryJawaban());
                                JSONObject jawaban = getJSON(req);
                                Log.e("data_jawaban", jawaban.toString());

                                runOnUiThread(() -> {
                                    if (jawaban == null) {
                                        Toast.makeText(getApplicationContext(),
                                                "Ada masalah pada jaringan, coba lagi.",
                                                Toast.LENGTH_LONG).show();
                                    }
                                    else if(getJSONString(jawaban, "status").equals("fail")){
                                        Toast.makeText(getApplicationContext(),
                                                "Data jawaban gagal disimpan, silakan hubungi admin.",
                                                Toast.LENGTH_LONG).show();
                                    }
                                    else {
                                        Toast.makeText(getApplicationContext(),
                                                "Jawaban berhasil diserahkan.",
                                                Toast.LENGTH_LONG).show();
                                        super.onBackPressed();
                                    }

                                    setLoading(false);
                                });
                        });
                    }).create().show();
                }
            }
        });
    }

    void setSoal(soalManager sManager){
        id_soal.setText(getJSONString(sManager.getSoal(show_soal), "id_soal"));
        no_soal.setText("Soal " + (show_soal + 1));
        bobot.setText("Bobot " + getJSONString(sManager.getSoal(show_soal), "bobot"));
        soal.setText(getJSONString(sManager.getSoal(show_soal), "soal"));
        jawaban.setText(sManager.getJawaban(show_soal));
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            jawaban.setFocusedByDefault(true);
        }

        // Prev
        if(!sManager.soalExitst(show_soal - 1))
            btnPrev.setVisibility(View.GONE);
        else {
            btnPrev.setVisibility(View.VISIBLE);
            btnPrev.setBootstrapText(new BootstrapText.Builder(this)
                    .addFontAwesomeIcon(FA_ARROW_LEFT)
                    .addText(" Soal " + show_soal)
                    .build());
            btnPrev.setOnClickListener(view -> {
                sManager.setJawaban(show_soal, jawaban);
                show_soal--;
                setSoal(sManager);
            });
        }

        // Next
        if(!sManager.soalExitst(show_soal + 1)) {
            btnNext.setVisibility(View.GONE);
        }
        else {
            btnNext.setVisibility(View.VISIBLE);
            btnNext.setBootstrapText(new BootstrapText.Builder(this)
                    .addText("Soal " + (show_soal + 2) + " ")
                    .addFontAwesomeIcon(FA_ARROW_RIGHT)
                    .build());
            btnNext.setOnClickListener(view -> {
                sManager.setJawaban(show_soal, jawaban);
                show_soal++;
                setSoal(sManager);
            });
        }
    }

    @Override
    public void onBackPressed() {
        new AlertDialog.Builder(this)
                .setTitle("Keluar dari tes materi ini?")
                .setMessage("Semua jawaban akan hilang.")
                .setNegativeButton("Tidak", null)
                .setPositiveButton("Ya", (arg0, arg1) -> {
                    super.onBackPressed();
                }).create().show();
    }

    void setLoading(boolean status){
        loading.setVisibility(status ? View.VISIBLE : View.GONE);
        jawaban.setEnabled(!status);
        btnPrev.setEnabled(!status);
        btnNext.setEnabled(!status);
        btnSubmit.setEnabled(!status);
    }

    void back2Login(){
        startActivity(new Intent(tesMateri.this, login.class));
        finish();
    }
}