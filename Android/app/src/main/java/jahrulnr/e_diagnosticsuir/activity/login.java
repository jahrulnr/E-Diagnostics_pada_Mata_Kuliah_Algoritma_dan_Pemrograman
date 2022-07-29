package jahrulnr.e_diagnosticsuir.activity;

import static jahrulnr.e_diagnosticsuir.lib.checkNetwork;
import static jahrulnr.e_diagnosticsuir.lib.getJSON;
import static jahrulnr.e_diagnosticsuir.lib.getJSONString;
import static jahrulnr.e_diagnosticsuir.lib.getRequest;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.beardedhen.androidbootstrap.BootstrapButton;
import com.beardedhen.androidbootstrap.BootstrapEditText;
import com.beardedhen.androidbootstrap.TypefaceProvider;

import org.json.JSONObject;

import java.io.File;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;

import jahrulnr.e_diagnosticsuir.R;
import jahrulnr.e_diagnosticsuir.config;

public class login extends AppCompatActivity {

    TextView reset_pass, about;
    BootstrapEditText npm, password;
    BootstrapButton btn_act;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
    }

    @Override
    protected void onStart() {
        super.onStart();
        TypefaceProvider.registerDefaultIconSets();

        String filename = new config().filename;
        File file = new File(getFilesDir()+File.separator+"data", filename);
        if(file.exists()){
            setContentView(R.layout.loading);
            Intent intent = new Intent(login.this, menu.class);
            intent.putExtra("logged", true);
            startActivity(intent);
            finish();
        }else{
            setContentView(R.layout.activity_login);
            npm = findViewById(R.id.npm);
            password = findViewById(R.id.password);
            reset_pass = findViewById(R.id.reset_pass);
            btn_act = findViewById(R.id.btn_form);
            about = findViewById(R.id.about);

            // setButton
            reset_pass.setOnClickListener(view -> {
                Uri uri = Uri.parse(new config().host + "#reset");
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            });
            about.setOnClickListener(view -> {
                Uri uri = Uri.parse(new config().host + "about");
                Intent intent = new Intent(Intent.ACTION_VIEW, uri);
                startActivity(intent);
            });
            btn_act.setOnClickListener(view -> {
                if(checkNetwork(this)){
                    // New method
                    ExecutorService executor = Executors.newSingleThreadExecutor();
                    executor.execute(() -> {
                        runOnUiThread(()->{
                            btn_act.setEnabled(false);
                        });

                        String data = "npm=" + npm.getText() + "&password=" + password.getText();
                        String req = getRequest("android/login", data);

                        runOnUiThread(()->{
                            String notif = null;
                            if (!req.isEmpty()) {
                                JSONObject json = getJSON(req);
                                if (getJSONString(json,"status").equals("success")) {
                                    notif = ("Login berhasil");
                                    Toast.makeText(getApplicationContext(), notif, Toast.LENGTH_LONG).show();
                                    Intent intent = new Intent(login.this, menu.class);
                                    intent.putExtra("login", true);
                                    intent.putExtra("data", json.toString());
                                    startActivity(intent);
                                    finish();
                                } else {
                                    notif = ("NPM/Password tidak terdaftar");
                                    Toast.makeText(getApplicationContext(), notif, Toast.LENGTH_LONG).show();
                                }
                            } else {
                                notif = ("Tidak dapat tersambung ke server, coba lagi nanti.");
                                Toast.makeText(getApplicationContext(), notif, Toast.LENGTH_LONG).show();
                            }
                            btn_act.setEnabled(true);
                        });
                    });
                }
            });
        }
    }
}