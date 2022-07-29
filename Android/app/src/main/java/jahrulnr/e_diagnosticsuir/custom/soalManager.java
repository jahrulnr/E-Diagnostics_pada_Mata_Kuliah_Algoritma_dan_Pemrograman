package jahrulnr.e_diagnosticsuir.custom;

import static jahrulnr.e_diagnosticsuir.lib.getJSON;
import static jahrulnr.e_diagnosticsuir.lib.getJSONArray;
import static jahrulnr.e_diagnosticsuir.lib.getJSONString;

import android.util.Log;
import android.widget.EditText;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import jahrulnr.e_diagnosticsuir.lib;

public class soalManager {
    private final int[] id_soal;
    private final String[] soal;
    private final float[] bobot;
    private final JSONArray jawaban = new JSONArray();

    public int length = -1;

    public soalManager(JSONArray data){
        this.id_soal = new int[data.length()];
        this.soal = new String[data.length()];
        this.bobot = new float[data.length()];
        this.length = data.length();

        if(data != null){
            for(int i = 0; i < data.length(); i++){
                try {
                    JSONObject data_soal = getJSON(data.getString(i));
//                    Log.e("opt_menu", data.toString());

                    this.id_soal[i] = lib.getJSONInteger(data_soal, "id_soal");
                    this.soal[i] = lib.getJSONString(data_soal, "soal");
                    this.bobot[i] = lib.getJSONFloat(data_soal, "bobot");
                } catch (JSONException e) {
                    Log.e("for->data_materi", e.getMessage());
                }
            }
        }
    }

    public JSONObject getSoal(int i) {
        try {
            return new JSONObject()
                    .put("id_soal", id_soal[i])
                    .put("soal", soal[i])
                    .put("bobot", Math.round(bobot[i]));
        }
        catch (JSONException e){
            return null;
        }
    }

    public boolean soalExitst(int i){
        return (i < length && i > -1);
    }

    public void setJawaban(int i, EditText jawaban){
        if (jawaban.getText().toString().length() > 0){
            try {
                Log.e("setJawaban", jawaban.getText().toString());
                JSONObject data = new JSONObject()
                        .put("id_soal", id_soal[i])
                        .put("jawaban", jawaban.getText().toString());
                this.jawaban.put(i, data);
            } catch (JSONException e) {
                Log.e("setJawaban", e.getMessage());
            }
        }
    }

    public String getJawaban() {
        Log.e("getJawaban()", jawaban.length() + "");
        return jawaban.length() > 0 ?
                jawaban.toString() : null;
    }

    public String getQueryJawaban(){
        Log.e("getJawaban()", jawaban.length() + "");
        return jawaban.length() > 0 ?
                "data=" + jawaban : null;
    }

    public String getJawaban(int i){
        try {
            return getJSONString(getJSON(jawaban.get(i).toString()), "jawaban");
        } catch (JSONException e) {
            Log.e("getJawaban("+i+")", e.getMessage());
            return null;
        }
    }

    public boolean isFull(){
        return jawaban.length() == id_soal.length;
    }
}
