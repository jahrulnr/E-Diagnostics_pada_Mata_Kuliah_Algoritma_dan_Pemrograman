package jahrulnr.e_diagnosticsuir.custom;

import android.annotation.SuppressLint;
import android.content.Context;
import android.content.Intent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.beardedhen.androidbootstrap.BootstrapLabel;

import jahrulnr.e_diagnosticsuir.R;
import jahrulnr.e_diagnosticsuir.activity.tesMateri;

public class materiAdapter extends BaseAdapter {
    Context context;
    String token;
    int[] id_materi, pertemuan, soal_exists, jawaban_exists;
    String[] materi;
    LayoutInflater inflter;

    public materiAdapter(Context context, String token, int[] id_materi, int[] pertemuan, String[] materi, int[] soal_exists, int[] jawaban_exists) {
        this.token = token;
        this.id_materi = id_materi;
        this.pertemuan = pertemuan;
        this.materi = materi;
        this.soal_exists = soal_exists;
        this.jawaban_exists = jawaban_exists;
        this.context = context;
        inflter = (LayoutInflater.from(context));
    }
    @Override
    public int getCount() {
        return id_materi.length;
    }
    @Override
    public Object getItem(int i) {
        return null;
    }
    @Override
    public long getItemId(int i) {
        return 0;
    }

    @SuppressLint({"ViewHolder", "InflateParams", "ResourceAsColor"})
    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        if (view == null) {
            view = inflter.inflate(R.layout.list_pertemuan, null);
        }

        RelativeLayout opt_materi = view.findViewById(R.id.layout_materi);
        if(soal_exists[i] == 0){
            opt_materi.setBackgroundResource(R.color.bootstrap_brand_danger);
        }
        else if(jawaban_exists[i] == 1){
            opt_materi.setBackgroundResource(R.color.bootstrap_brand_success);
        }

        TextView t_id_materi = view.findViewById(R.id.id_materi);
        BootstrapLabel t_pertemuan = view.findViewById(R.id.pertemuan);
        BootstrapLabel b_materi = view.findViewById(R.id.materi);
        t_id_materi.setText(String.valueOf(id_materi[i]));
        t_pertemuan.setText(String.valueOf(pertemuan[i]));
        b_materi.setText(materi[i]);

        b_materi.setOnClickListener(view1 -> {
            if(soal_exists[i] == 0){
                Toast.makeText(
                        context,
                        "Materi belum dibuat, silakan tunggu konfirmasi dari dosen pengampu.",
                        Toast.LENGTH_SHORT
                ).show();
            }
            else if(jawaban_exists[i] == 0) {
                // change activity
                Intent intent = new Intent(context, tesMateri.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                intent.putExtra("_token", token);
                intent.putExtra("id_materi", id_materi[i] + "");
                intent.putExtra("judul_materi", materi[i]);
                context.startActivity(intent);
            }
            else {
                Toast.makeText(
                        context,
                        "Materi telah dijawab",
                        Toast.LENGTH_SHORT
                ).show();
            }
        });

        return view;
    }
}
