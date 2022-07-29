package jahrulnr.e_diagnosticsuir;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.StrictMode;
import android.util.Log;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.math.BigDecimal;
import java.net.SocketTimeoutException;
import java.net.URL;
import java.net.URLConnection;

public class lib {
    private static String text = "";
    private static Activity activity;

    public lib(Activity act){
        activity = act;
    }

    public static boolean checkNetwork(Activity act){
        boolean connected = false;
        ConnectivityManager connectivityManager = (ConnectivityManager)act.getSystemService(Context.CONNECTIVITY_SERVICE);
        if(connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == NetworkInfo.State.CONNECTED ||
                connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_WIFI).getState() == NetworkInfo.State.CONNECTED) {
            connected = true;
            Log.i("Internet", "Connected");
        }else{
            Toast.makeText(act.getApplicationContext(), "Internet tidak tersedia.", Toast.LENGTH_LONG).show();
            Log.i("Internet", "Not connected");
        }

        return connected;
    }

    // Without Data
    public static String getRequest(String api) {
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);

        config conf = new config();
        BufferedReader reader=null;
        URL url = null;
        URLConnection conn = null;

        try{
            // Defined URL  where to send data
            url = new URL(conf.host + api);

            // Send POST data request
            conn = url.openConnection();
            conn.setConnectTimeout(5*1000);
            conn.setDoOutput(true);

            // Get the server response
            reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            StringBuilder sb = new StringBuilder();
            String line = null;

            // Read Server Response
            while((line = reader.readLine()) != null){
                // Append server response in string
                sb.append(line + "\n");
            }

            if(!sb.toString().isEmpty())
                text = sb.substring(0, sb.length()-1);
            else
                text = sb.toString();
        }
        catch (SocketTimeoutException e){
            Log.e("SocketTimeoutException", e.toString());
            return null;
        }
        catch (UnsupportedEncodingException e) {
            Log.e("UnsupportedEncoding", e.toString());
            e.printStackTrace();
            return null;
        }
        catch (IOException e) {
            Log.e("IOException", e.toString());
            e.printStackTrace();
            return null;
        }
        catch(Exception ex){
            Log.e("getRequest_1", ex.getMessage());
            ex.printStackTrace();
            return null;
        }

        finally{
            try{
                reader.close();
            }catch(Exception ex) {
                Log.e("getRequest_2", ex.toString());
                return null;
            }
        }

        // return response
//        Log.d("getRequest_3", text);
        return text;
    }

    // With Data
    public static String getRequest(String api, String data) {
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);

        config conf = new config();
        BufferedReader reader=null;
        URL url = null;
        URLConnection conn = null;

        try{
            // Defined URL  where to send data
            url = new URL(conf.host + api);

            // Send POST data request
            conn = url.openConnection();
            conn.setConnectTimeout(5*1000);
            conn.setDoOutput(true);
            OutputStreamWriter wr = new OutputStreamWriter(conn.getOutputStream());
            wr.write( data );
            wr.flush();

            // Get the server response
            reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            StringBuilder sb = new StringBuilder();
            String line = null;

            // Read Server Response
            while((line = reader.readLine()) != null){
                // Append server response in string
                sb.append(line + "\n");
            }

            if(!sb.toString().isEmpty())
                text = sb.substring(0, sb.length()-1);
            else
                text = sb.toString();
        }
        catch (SocketTimeoutException e){
            Log.e("SocketTimeoutException", e.toString());
            Toast.makeText(activity, "Koneksi timeout. Silakan refresh.", Toast.LENGTH_LONG).show();
            return null;
        }
        catch (UnsupportedEncodingException e) {
            Log.e("UnsupportEncoding", e.toString());
            e.printStackTrace();
            Toast.makeText(activity, "Ada masalah, coba lagi.", Toast.LENGTH_LONG).show();
            return null;
        }
        catch (IOException e) {
            Log.e("IOException", e.toString());
            e.printStackTrace();
            Toast.makeText(activity, "Ada masalah, coba lagi.", Toast.LENGTH_LONG).show();
            return null;
        }
        catch(Exception ex){
            Log.e("getRequest_1", ex.getMessage());
            ex.printStackTrace();
            Toast.makeText(activity, "Ada masalah, coba lagi.", Toast.LENGTH_LONG).show();
            return null;
        }

        finally{
            try{
                reader.close();
            }catch(Exception ex) {
                Log.e("getRequest_2", ex.toString());
                Toast.makeText(activity, "Ada masalah. Silakan refresh.", Toast.LENGTH_LONG).show();
                return null;
            }
        }

        return text;
    }

    public static JSONArray getJSONArray(String json){
        try{
            JSONArray arr = new JSONArray(json);
            return arr;
        } catch (JSONException e) {
            Log.e("JSONArray", e.getMessage());
            return null;
        }
    }

    public static JSONObject getJSON(String json){
        try{
            JSONObject obj = new JSONObject(json);
            return obj;
        } catch (JSONException e) {
            Log.e("JSONObject", e.getMessage());
            return null;
        }
    }

    public static Object getJSONObject(JSONObject json, String key){
        try{
            return json.get(key);
        } catch (JSONException e) {
            Log.e("getJSON", e.getMessage());
            return null;
        }
    }

    public static String getJSONString(JSONObject json, String key){
        try{
            return json.getString(key);
        } catch (JSONException e) {
            Log.e("getJSON", e.getMessage());
            return null;
        }
    }

    public static Boolean getJSONBoolean(JSONObject json, String key){
        try{
            return json.getBoolean(key);
        } catch (JSONException e) {
            Log.e("getJSON", e.getMessage());
            return null;
        }
    }

    public static int getJSONInteger(JSONObject json, String key){
        try{
            return json.getInt(key);
        } catch (JSONException e) {
            Log.e("getJSON", e.getMessage());
            return 0;
        }
    }

    public static float getJSONFloat(JSONObject json, String key) {
        try{
            return BigDecimal.valueOf(json.getDouble(key)).floatValue();
        } catch (JSONException e) {
            Log.e("getJSON", e.getMessage());
            return 0;
        }
    }
}

