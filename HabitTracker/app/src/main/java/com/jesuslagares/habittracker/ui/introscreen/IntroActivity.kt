package com.jesuslagares.habittracker.ui.introscreen

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import androidx.viewpager2.widget.ViewPager2
import com.jesuslagares.habittracker.R
import com.jesuslagares.habittracker.data.models.IntroView
import com.jesuslagares.habittracker.ui.MainActivity
import com.jesuslagares.habittracker.ui.auth.AuthActivity
import com.jesuslagares.habittracker.ui.introscreen.adapters.ViewPagerIntroAdapter
import kotlinx.android.synthetic.main.activity_intro.*

class IntroActivity : AppCompatActivity() {

    lateinit var introView: List<IntroView>

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_intro)

        addToIntroView()

        viewPager2.adapter = ViewPagerIntroAdapter(introView)
        viewPager2.orientation = ViewPager2.ORIENTATION_HORIZONTAL

        circleIndicator.setViewPager(viewPager2)

        viewPager2.registerOnPageChangeCallback(object : ViewPager2.OnPageChangeCallback() {
            override fun onPageScrolled(
                position: Int,
                positionOffset: Float,
                positionOffsetPixels: Int
            ) {
                if (position == 1) {
                    animationButton()
                }
                super.onPageScrolled(position, positionOffset, positionOffsetPixels)
            }
        })
    }

    private fun animationButton() {
        btn_start_app.visibility = View.VISIBLE

        btn_start_app.animate().apply {
            duration = 1400
            alpha(1f)

            btn_start_app.setOnClickListener {
                val intent = Intent(applicationContext, MainActivity::class.java)
                startActivity(intent)
                finish()
            }
        }.start()
    }

    private fun addToIntroView() {
        //Create some items that you want to add to your viewpager

        introView = listOf(
            IntroView("Welcome to Habit Tracker!", R.drawable.ic_baseline_self_improvement),
            IntroView("This app has pedometer!", R.drawable.ic_baseline_directions_walk_24),
            )
    }
}
