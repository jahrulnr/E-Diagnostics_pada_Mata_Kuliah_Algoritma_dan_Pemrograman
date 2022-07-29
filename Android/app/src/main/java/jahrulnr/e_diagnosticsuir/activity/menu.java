package jahrulnr.e_diagnosticsuir.activity;

import static jahrulnr.e_diagnosticsuir.lib.getJSON;
import static jahrulnr.e_diagnosticsuir.lib.getJSONArray;
import static jahrulnr.e_diagnosticsuir.lib.getJSONInteger;
import static jahrulnr.e_diagnosticsuir.lib.getJSONString;
import static jahrulnr.e_diagnosticsuir.lib.getRequest;

import android.app.AlertDialog;
import android.content.Intent;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.text.Html;
import android.text.TextUtils;
import android.util.Log;
import android.util.Patterns;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.WebView;
import android.widget.GridView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import com.beardedhen.androidbootstrap.BootstrapButton;
import com.beardedhen.androidbootstrap.BootstrapEditText;
import com.beardedhen.androidbootstrap.TypefaceProvider;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import jahrulnr.e_diagnosticsuir.R;
import jahrulnr.e_diagnosticsuir.config;
import jahrulnr.e_diagnosticsuir.custom.materiAdapter;
import jahrulnr.e_diagnosticsuir.lib;

public class menu extends AppCompatActivity {

    private final String filename = new config().filename;
    config cnf = new config(this);
    String token = null;
    Intent intent;
    LinearLayout loading;
    BootstrapButton refresh, about, d_materi, btnMateri, btnHasilTes, btnProfil, btnKeluar;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        // Set window bar
        Window window = getWindow();
        window.clearFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_STATUS);
        window.addFlags(WindowManager.LayoutParams.FLAG_DRAWS_SYSTEM_BAR_BACKGROUNDS);
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.LOLLIPOP) {
            window.setStatusBarColor(ContextCompat.getColor(this,R.color.bootstrap_gray));
        }
    }

    @Override
    protected void onStart() {
        super.onStart();
        TypefaceProvider.registerDefaultIconSets();

        // Get Data login
        intent = getIntent();

        // if data is empty
        if(intent.getBooleanExtra("login", false))
            makeData(intent.getStringExtra("data"));

        // if jumping activity
        if(!intent.getBooleanExtra("login", false)
                && !intent.getBooleanExtra("logged", false))
            back2Login();

        // Menu
        setContentView(R.layout.menu);
        hideMenu();
        loading = findViewById(R.id.login_container);
        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.GONE);
        about = findViewById(R.id.about);
        about.setOnClickListener(view -> {
            Uri uri = Uri.parse(cnf.host + "about");
            Intent intent = new Intent(Intent.ACTION_VIEW, uri);
            startActivity(intent);
        });

        // Set Nama
        String nama = getJSONString(getData(), "nama");
        TextView sNama = findViewById(R.id.sambutanNama);
        nama = nama.length() > 20 ? nama.substring(0, 20) + "..." : nama;
        sNama.setText(
            sNama.getText().toString().replace("--nama--", nama)
        );

        // set Button Menu
        d_materi = findViewById(R.id.btn_dMateri);
        btnMateri = findViewById(R.id.btnMateri);
        btnHasilTes = findViewById(R.id.btnHasilTes);
        btnProfil = findViewById(R.id.btnProfil);
        btnKeluar = findViewById(R.id.btnKeluar);

        // set Click Action
        d_materi.setOnClickListener(view -> get_dMateri());
        btnMateri.setOnClickListener(view -> getMateri());
        btnHasilTes.setOnClickListener(view -> getHasilTes());
        btnProfil.setOnClickListener(view -> getProfil());
        btnKeluar.setOnClickListener(view -> {
            new AlertDialog.Builder(this)
                    .setMessage("Keluar dari akun ini?")
                    .setNegativeButton("Tidak", null)
                    .setPositiveButton("Ya", (arg0, arg1) -> {
                        deleteData();
                    }).create().show();
        });
    }

    @Override
    public void onBackPressed() {
        new AlertDialog.Builder(this)
            .setMessage("Keluar Aplikasi?")
                .setNegativeButton("Tidak", null)
                .setPositiveButton("Ya", (arg0, arg1) -> {
                finish();
                System.exit(0);
            }).create().show();
    }

    void hideMenu(){
        LinearLayout ly_dMateri = findViewById(R.id.ly_dMateri),
                     ly_materi = findViewById(R.id.ly_materi),
                     ly_hasilTes = findViewById(R.id.ly_hasilTes);
        RelativeLayout ly_profil = findViewById(R.id.ly_profil);
        ly_dMateri.setVisibility(View.GONE);
        ly_materi.setVisibility(View.GONE);
        ly_hasilTes.setVisibility(View.GONE);
        ly_profil.setVisibility(View.GONE);
    }

    void get_dMateri(){
        hideMenu();
        setLoading(true);
        LinearLayout ly_dMateri = findViewById(R.id.ly_dMateri);
        WebView d_materi = findViewById(R.id.d_materi);
        ExecutorService executor = Executors.newSingleThreadExecutor();
        executor.execute(() -> {
            String req = getRequest("android/download/materi/" + getJSONString(getData(), "_token"));

            runOnUiThread(()->{
                if(req != null) {
                    d_materi.loadDataWithBaseURL(null, req, "text/html", "utf-8", null);
                    ly_dMateri.setVisibility(View.VISIBLE);
                }
                else {
                    Log.e("get_dMateri()", req);
                    ly_dMateri.setVisibility(View.GONE);
                    Toast.makeText(
                            getApplicationContext(),
                            "Gagal memuat data materi, coba lagi.",
                            Toast.LENGTH_SHORT
                    ).show();
                }
                setLoading(false);
            });
        });

        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.VISIBLE);
        refresh.setOnClickListener(view -> get_dMateri());
    }

    void getMateri(){
        hideMenu();
        setLoading(true);
        LinearLayout ly_materi = findViewById(R.id.ly_materi);

        GridView gridView = findViewById(R.id.option_pertemuan);
        ExecutorService executor = Executors.newSingleThreadExecutor();
        executor.execute(() -> {
            String req = getRequest("android/materi2/" + lib.getJSONString(getData(), "_token"));
            if(req == null){
                runOnUiThread(()->{
                    Toast.makeText(
                            getApplicationContext(),
                            "Gagal memuat materi, coba lagi.",
                            Toast.LENGTH_SHORT
                    ).show();
                    setLoading(false);
                    ly_materi.setVisibility(View.GONE);
                });
                return;
            }
            JSONArray data_materi = getJSONArray(req);
            int[] id_materi = new int[data_materi.length()],
                  pertemuan = new int[data_materi.length()],
                  soal_exists = new int[data_materi.length()],
                  jawaban_exists = new int[data_materi.length()];
            String[] materi = new String[data_materi.length()];

            if(data_materi != null){
                for(int i = 0; i < data_materi.length(); i++){
                    try {
                        JSONObject data = getJSON(data_materi.getString(i));
                        Log.e("opt_menu", data.toString());
                        id_materi[i] = getJSONInteger(data, "id_materi");
                        pertemuan[i] = getJSONInteger(data, "pertemuan");
                        materi[i] = getJSONString(data, "judul_materi");
                        soal_exists[i] = getJSONInteger(data, "soal_exists");
                        jawaban_exists[i] = getJSONInteger(data, "jawaban_exists");
                    } catch (JSONException e) {
                        Log.e("for->data_materi", e.getMessage());
                        Toast.makeText(
                                getApplicationContext(),
                                "Gagal memuat materi, coba lagi.",
                                Toast.LENGTH_SHORT
                        ).show();
                        setLoading(false);
                        ly_materi.setVisibility(View.GONE);
                        return;
                    }
                }
            }

            runOnUiThread(()->{
                if(id_materi.length > 0) {
                    materiAdapter mAdapter = new materiAdapter(getApplicationContext(), getJSONString(getData(), "_token"), id_materi, pertemuan, materi, soal_exists, jawaban_exists);
                    gridView.setAdapter(mAdapter);

                    // Test
                    LinearLayout.LayoutParams params = (LinearLayout.LayoutParams) btnMateri.getLayoutParams();
                    RelativeLayout.LayoutParams materiParams = (RelativeLayout.LayoutParams) ly_materi.getLayoutParams();
                    materiParams.height = (int) (params.height * Math.round(id_materi.length / 1.5));
                    ly_materi.setLayoutParams(materiParams);
                    ly_materi.setVisibility(View.VISIBLE);
                }
                else{
                    Toast.makeText(
                            getApplicationContext(),
                            "Gagal memuat materi, coba lagi.",
                            Toast.LENGTH_SHORT
                    ).show();
                }

                setLoading(false);
            });
        });

        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.VISIBLE);
        refresh.setOnClickListener(view -> getMateri());
    }

    void getHasilTes(){
        hideMenu();
        setLoading(true);
        LinearLayout ly_hasilTes = findViewById(R.id.ly_hasilTes);
        WebView hasilTest = findViewById(R.id.hasilTes);
        ExecutorService executor = Executors.newSingleThreadExecutor();
        executor.execute(() -> {
            String req = getRequest("android/hasil/tes/" + getJSONString(getData(), "_token"));

            runOnUiThread(()->{
                if(req != null) {
                    Log.e("getHasilTes()", req);
                    hasilTest.loadDataWithBaseURL(null, req, "text/html", "utf-8", null);
                    ly_hasilTes.setVisibility(View.VISIBLE);
                }
                else {
                    ly_hasilTes.setVisibility(View.GONE);
                    Toast.makeText(
                            getApplicationContext(),
                            "Gagal memuat data hasil tes, coba lagi.",
                            Toast.LENGTH_SHORT
                    ).show();
                }
                setLoading(false);
            });
        });

        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.VISIBLE);
        refresh.setOnClickListener(view -> getHasilTes());
    }

    void getProfil(){
        hideMenu();
        RelativeLayout ly_profil = findViewById(R.id.ly_profil);
        setLoading(true);

        BootstrapEditText npm, nama, email, kelas, password;
        npm = findViewById(R.id.npm);
        nama = findViewById(R.id.nama);
        email = findViewById(R.id.email);
        kelas = findViewById(R.id.kelas);
        password = findViewById(R.id.password);

        ExecutorService executor = Executors.newSingleThreadExecutor();
        executor.execute(() -> {
            String data = getRequest("android/profil/" + lib.getJSONString(getData(), "_token"));
            JSONObject data_profil = new JSONObject();
            if(data != null) {
                data_profil = getJSON(data);
            } else {
                runOnUiThread(()->{
                    Toast.makeText(getApplicationContext(), "Gagal memuat data profil", Toast.LENGTH_SHORT).show();
                    ly_profil.setVisibility(View.GONE);
                    setLoading(false);
                    return;
                });
            }

            JSONObject finalData_profil = data_profil;
            runOnUiThread(()->{
                if(finalData_profil.length() > 0) {
                    if (lib.getJSONString(finalData_profil, "status").equals("success")) {
                        npm.setText(lib.getJSONString(finalData_profil, "npm"));
                        nama.setText(lib.getJSONString(finalData_profil, "nama_mhs"));
                        email.setText(lib.getJSONString(finalData_profil, "email"));
                        kelas.setText(lib.getJSONString(finalData_profil, "kelas"));
                        ly_profil.setVisibility(View.VISIBLE);
                    } else
                        Toast.makeText(getApplicationContext(), "Gagal memuat data profil", Toast.LENGTH_SHORT).show();
                } else
                    Toast.makeText(getApplicationContext(), "Gagal memuat data profil", Toast.LENGTH_SHORT).show();

                setLoading(false);
            });
        });

        refresh = findViewById(R.id.refresh);
        refresh.setVisibility(View.VISIBLE);
        refresh.setOnClickListener(view -> getProfil());

        BootstrapButton simpan = findViewById(R.id.simpan_profil);
        simpan.setOnClickListener(view -> {
            // validasi
            if(TextUtils.isEmpty(email.getText().toString())
                    || !Patterns.EMAIL_ADDRESS.matcher(email.getText().toString()).matches()) {
                Toast.makeText(getApplicationContext(),
                        "Email tidak valid",
                        Toast.LENGTH_SHORT).show();
                return;
            }
            if(password.getText().length() > 0 && password.getText().length() < 5) {
                Toast.makeText(getApplicationContext(),
                        "Password minimal 5 karakter",
                        Toast.LENGTH_SHORT).show();
                return;
            }

            simpan.setEnabled(false);
            executor.execute(() -> {
                String data = "email=" + email.getText().toString() +
                        "&" +
                        "password" + password.getText().toString();
                String req = getRequest("android/simpan/profil/" +
                        lib.getJSONString(getData(), "_token"), data);

                runOnUiThread(()->{
                    String notif = null;
                    if (!req.isEmpty()) {
                        JSONObject json = getJSON(req);
                        Log.e("simpan_profil", json.toString());
                        if (getJSONString(json,"status").equals("success")) {
                            notif = ("Berhasil disimpan");
                            makeData(json.toString());
                            token = null;
                        } else if(getJSONString(json,"email").equals("fail")){
                            notif = ("Email tidak valid");
                        } else if(getJSONString(json,"password").equals("fail")){
                            notif = ("Password harus 5 karakter atau lebih");
                        } else {
                            notif = "Gagal menyimpan, coba lagi.";
                        }
                    } else {
                        notif = ("Tidak dapat tersambung ke server, coba lagi nanti.");
                    }

                    Toast.makeText(getApplicationContext(), notif, Toast.LENGTH_SHORT).show();
                    simpan.setEnabled(true);
                });
            });
        });
    }

    void setLoading(boolean status){
        loading.setVisibility(status ? View.VISIBLE : View.GONE);
        btnMateri.setEnabled(!status);
        btnHasilTes.setEnabled(!status);
        btnProfil.setEnabled(!status);
        btnKeluar.setEnabled(!status);
    }

    void makeData(String data){
        File path = new File(getFilesDir()+File.separator+"data");
        if(!path.exists()) path.mkdirs();

        File file = new File(getFilesDir()+File.separator+"data", filename);
        if(!file.exists()) file.delete();

        FileOutputStream stream = null;
        try {
            stream = new FileOutputStream(file);
            stream.write(data.getBytes());
            stream.close();
        } catch (IOException e) {
            Log.e("makeData", e.toString());
        }
    }

    JSONObject getData(){
        if(this.token == null) {
            File file = new File(getFilesDir() + File.separator + "data", filename);
            int length = (int) file.length();
            byte[] bytes = new byte[length];

            if (!file.exists()) return null;
            FileInputStream stream = null;
            try {
                stream = new FileInputStream(file);
                stream.read(bytes);
                stream.close();
            } catch (FileNotFoundException e) {
                Log.e("getData", e.toString());
            } catch (IOException e) {
                Log.e("getData", e.toString());
            }

            //        Log.e("getJSON", new String(bytes));
            this.token = new String(bytes);
        }

        return getJSON(this.token);
    }

    void deleteData(){
        File file = new File(getFilesDir()+File.separator+"data", filename);
        file.delete();
        back2Login();
    }

    void back2Login(){
        startActivity(new Intent(menu.this, login.class));
        finish();
    }
}
