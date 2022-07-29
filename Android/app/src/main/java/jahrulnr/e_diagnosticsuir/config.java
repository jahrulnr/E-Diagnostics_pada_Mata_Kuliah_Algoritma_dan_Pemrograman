package jahrulnr.e_diagnosticsuir;

import static jahrulnr.e_diagnosticsuir.lib.getRequest;

import android.app.Activity;
import android.util.Log;
import android.view.View;
import android.widget.LinearLayout;

import com.beardedhen.androidbootstrap.BootstrapButton;

public class config {
    public String host = "https://e-diagnostics.jahrulnr.site/";
    public String filename = "user.json";

    private Activity activity;
    private final boolean show_side_menu = true;

    public config(){
    }

    public config(Activity activity){
        this.activity = activity;
    }
}
